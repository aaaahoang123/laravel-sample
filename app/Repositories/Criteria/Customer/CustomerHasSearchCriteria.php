<?php
/**
 * @Author Hoang Do
 * @Created 1/6/21 2:50 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Repositories\Criteria\Customer;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CustomerHasSearchCriteria implements CriteriaInterface
{
    private string $search;

    public function __construct(string $search)
    {
        $this->search = "%$search%";
    }

    /**
     * @param Model|Builder $model
     * @param RepositoryInterface $repository
     * @return mixed|void
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(fn(Builder $q) =>
            $q->where('phone_number', 'like', $this->search)
                ->orWhere('email', 'like', $this->search)
                ->orWhere('name', 'like', $this->search)
        );
    }
}
