<?php

namespace App\Repositories\Criteria\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductHasSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\Product;
 */
class ProductHasSearchCriteria implements CriteriaInterface
{
    private string $search;

    public function __construct(string $search)
    {
        $this->search = $search;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $slug = '%' . Str::lower(Str::slug($this->search)) . '%';
        $trueSearch = '%' . $this->search . '%';
        return $model->where(
            fn(Builder $q) => $q->where('name', 'like', $trueSearch)
                    ->orWhere('slug', 'like', $slug)
                    ->orWhereHas(
                        'tags',
                        fn(Builder $q1) => $q1->where('name', 'like', $trueSearch)
                            ->orWhere('slug', 'like', $slug)
                    )
        );
    }
}
