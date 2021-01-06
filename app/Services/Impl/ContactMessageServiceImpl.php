<?php
/**
 * @Author Hoang Do
 * @Created 1/5/21 11:06 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Services\Impl;


use App\Enums\Status\ContactMessageStatus;
use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Queue\Events\ContactMessageCreated;
use App\Repositories\Contract\ContactMessageRepository;
use App\Repositories\Contract\CustomerRepository;
use App\Repositories\Criteria\ContactMessage\ContactMessageHasSearchCriteria;
use App\Services\Contract\ContactMessageService;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Criteria\WhereCriteria;
use HoangDo\Common\Enum\CommonStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContactMessageServiceImpl implements ContactMessageService
{
    private CustomerRepository $customerRepo;
    private ContactMessageRepository $contactRepo;

    public function __construct(
        CustomerRepository $customerRepo,
        ContactMessageRepository $contactRepo
    )
    {
        $this->customerRepo = $customerRepo;
        $this->contactRepo = $contactRepo;
    }

    public function create(ContactMessageRequest $req): ContactMessage
    {
        $customer = $this->resolveCustomer($req);
        $message = new ContactMessage();
        $message->customer()->associate($customer);
        $message->subject = $req->subject;
        $message->message = $req->message;
        $message->email = $customer->email;

        $message = $this->contactRepo->save($message);
        event(new ContactMessageCreated($message->id));
        return $message;
    }

    public function list($query, $limit): LengthAwarePaginator
    {
        $this->contactRepo->with(['customer'])->orderBy('created_at', 'desc');
        if ($search = $query['search'] ?? null)
            $this->contactRepo->pushCriteria(new ContactMessageHasSearchCriteria($search));
        if (!empty($query['read']))
            $this->contactRepo->pushCriteria(new WhereCriteria('read', $query['read'] === 'true'));
        if ($status = $query['status'] ?? null)
            $this->contactRepo->pushCriteria(new HasStatusCriteria($status));

        return $this->contactRepo->paginate($limit);
    }

    public function read($id): ContactMessage
    {
        return $this->contactRepo->markAsRead($id);
    }

    public function resolve($id): ContactMessage
    {
        return $this->contactRepo->updateStatus($id, ContactMessageStatus::RESOLVED);
    }

    public function delete($id): ContactMessage
    {
        return $this->contactRepo->updateStatus($id, ContactMessageStatus::DELETED);
    }

    private function resolveCustomer(ContactMessageRequest $req): Customer
    {
        $this->customerRepo->pushCriteria(new WhereCriteria('phone_number', $req->phone_number));
        /** @var Customer $customer */
        $customer = $this->customerRepo->first();

        if ($customer && $customer->status == CommonStatus::INACTIVE) {
            throw new BadRequestHttpException(__('messages.you_has_been_in_blacklist'));
        }

        if (!$customer)
            $customer = new Customer([
                'phone_number' => $req->phone_number
            ]);

        if ($customer->email != $req->email)
            $customer->email = $req->email;
        if ($customer->name != $req->name)
            $customer->name = $req->name;

        return $this->customerRepo->save($customer);
    }


}
