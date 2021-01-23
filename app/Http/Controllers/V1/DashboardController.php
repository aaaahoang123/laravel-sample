<?php
/**
 * @Author: Hoang Do
 * @Date: 23/01/2021
 * @Using: PhpStorm
 */

namespace App\Http\Controllers\V1;


use App\Enums\Status\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Services\Contract\ContactMessageService;
use App\Services\Contract\CustomerService;
use App\Services\Contract\ProductService;
use HoangDo\Common\Enum\CommonStatus;

class DashboardController extends Controller
{
    private CustomerService $customerService;
    private ProductService $productService;
    private ContactMessageService $contactMessageService;

    public function __construct(CustomerService $customerService, ProductService $productService, ContactMessageService $contactMessageService)
    {
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->contactMessageService = $contactMessageService;
    }

    public function customerCounts(): array {
        $active = $this->customerService->countCustomerByStatus(CommonStatus::ACTIVE);
        $inactive = $this->customerService->countCustomerByStatus(CommonStatus::INACTIVE);
        $total = $active + $inactive;
        return compact('active', 'inactive', 'total');
    }

    public function productCounts(): array {
        $active = $this->productService->countByStatus(CommonStatus::ACTIVE);
        $inactive = $this->productService->countByStatus(CommonStatus::INACTIVE);
        $total = $active + $inactive;
        return compact('active', 'inactive', 'total');
    }

    public function contactMessagesCount(): array {
        $waiting = $this->contactMessageService->countByStatus(ContactMessageStatus::WAITING);
        $unread = $this->contactMessageService->countByRead(false);
        return compact('waiting', 'unread');
    }
}
