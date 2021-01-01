<?php

namespace App\Repositories\Criteria\Tag;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TagHasSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\Tag;
 */
class TagHasSearchCriteria implements CriteriaInterface
{
    private string $search;

    public function __construct(string $search)
    {
        $this->search = $search;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $search = '%' . $this->search . '%';
        $slugSearch = '%' . Str::lower(Str::slug($search, ' ')) . '%';
        return $model->where(
            fn(Builder $q) => $q->where('name', 'like', $search)
                ->orWhere('slug', 'like', $slugSearch)
        );
    }
}
