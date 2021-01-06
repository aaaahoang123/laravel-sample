<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Repository\RepositoryEloquent;
use App\Repositories\Contract\CustomerRepository;
use App\Models\Customer;

/**
 * Class CustomerRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CustomerRepositoryEloquent extends RepositoryEloquent implements CustomerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
