<?php

namespace App\Repositories\Criteria\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductOfCategoryCriteria.
 *
 * @package namespace App\Repositories\Criteria\Product;
 */
class BelongToCategoryCriteria implements CriteriaInterface
{
    /**
     * @var Collection|array
     */
    private $category;

    public function __construct($category)
    {
        $this->category = $category;
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
        return $model->whereIn('category_id', $this->category);
    }
}
