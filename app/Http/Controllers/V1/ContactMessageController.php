<?php
/**
 * @Author Hoang Do
 * @Created 1/5/21 1:44 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use App\Services\Contract\ContactMessageService;
use HoangDo\Common\Helper\Utils;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    private ContactMessageService $contactMessageService;

    public function __construct(
        ContactMessageService $contactMessageService
    )
    {
        $this->contactMessageService = $contactMessageService;
    }

    public function create(ContactMessageRequest $req): ContactMessage
    {
        return $this->contactMessageService->create($req);
    }

    public function markAsRead($id): ContactMessage
    {
        return $this->contactMessageService->read($id);
    }

    public function markAsResolved($id): ContactMessage
    {
        return $this->contactMessageService->resolve($id);
    }

    public function markAsDeleted($id): ContactMessage
    {
        return $this->contactMessageService->delete($id);
    }

    public function list(Request $req): array
    {
        $pageData = $this->contactMessageService->list($req->query(), $req->get('limit') ?? 20);
        return [
            'datas' => $pageData->items(),
            'meta' => Utils::getMeta($pageData)
        ];
    }
}
