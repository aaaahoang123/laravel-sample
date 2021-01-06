<?php
/**
 * @Author Hoang Do
 * @Created 1/5/21 1:48 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Repositories\Criteria\ContactMessage;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ContactMessageHasSearchCriteria implements CriteriaInterface
{
    private $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * @param Model|Builder $model
     * @param RepositoryInterface $repository
     * @return mixed|void
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $trueSearch = '%' . $this->search . '%';

        return $model->where(fn(Builder $q) =>
            $q->where('subject', 'like', $trueSearch)
                ->orWhere('email', 'like', $trueSearch)
                ->orWhereHas('customer', fn(Builder $q1) =>
                    $q1->where('phone_number', 'like', $trueSearch)
                    ->orWhere('name', 'like', $trueSearch)
                )
        );
    }
}
