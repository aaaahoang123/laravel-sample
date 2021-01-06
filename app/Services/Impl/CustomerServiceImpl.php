<?php
/**
 * @Author Hoang Do
 * @Created 1/6/21 11:32 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Services\Impl;


use App\Repositories\Contract\CustomerRepository;
use App\Repositories\Criteria\Customer\CustomerHasSearchCriteria;
use App\Services\Contract\CustomerService;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;

class CustomerServiceImpl extends SimpleService implements CustomerService
{
    private CustomerRepository $customerRepo;

    public function __construct(
        CustomerRepository $customerRepo
    )
    {
        $this->customerRepo = $customerRepo;
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->customerRepo;
        $props->listIgnoreStatus = true;

        return $props;
    }

    protected function queryToCriteria(array $query): array
    {
        $criteria = [];

        if ($status = $query['status'] ?? null)
            $criteria[] = new HasStatusCriteria($status);

        if ($search = $query['search'] ?? null)
            $criteria[] = new CustomerHasSearchCriteria($search);

        return $criteria;
    }
}
