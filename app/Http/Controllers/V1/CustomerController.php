<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\Contract\CustomerService;
use HoangDo\Common\Helper\Utils;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private CustomerService $customerService;

    public function __construct(
        CustomerService $customerService
    )
    {
        $this->customerService = $customerService;
    }

    public function index(Request $req): array
    {
        $pageData = $this->customerService->listAll($req->query(), $req->query('limit') ?? 20);
        return [
            'datas' => $pageData->items(),
            'meta' => Utils::getMeta($pageData)
        ];
    }

    public function store(CustomerRequest $request)
    {
        return $this->customerService->create($request);
    }

    public function show($id)
    {
        return $this->customerService->single($id);
    }

    public function update(CustomerRequest $request, $id)
    {
        return $this->customerService->edit($id, $request);
    }

    public function destroy($id)
    {
        return $this->customerService->delete($id);
    }
}
