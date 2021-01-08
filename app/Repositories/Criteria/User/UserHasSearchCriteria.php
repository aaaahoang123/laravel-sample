<?php
/**
 * @Author Hoang Do
 * @Created 1/8/21 2:52 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Repositories\Criteria\User;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserHasSearchCriteria implements CriteriaInterface
{
    private $search;

    public function __construct($search)
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
            $q->where('name', 'like', $this->search)
                ->orWhere('email', 'like', $this->search)
                ->orWhere('username', 'like', $this->search)
        );
    }
}
