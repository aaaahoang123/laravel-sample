<?php
/**
 * @Author Hoang Do
 * @Created 1/6/21 11:31 AM
 * @By PhpStorm on Ubuntu
 */

namespace App\Services\Contract;


use HoangDo\Common\Service\Service;

interface CustomerService extends Service
{
    public function countCustomerByStatus($status = null): int;
}
