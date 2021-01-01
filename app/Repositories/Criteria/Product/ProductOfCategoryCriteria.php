<?php

namespace App\Repositories\Criteria\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductOfCategoryCriteria.
 *
 * @package namespace App\Repositories\Criteria\Product;
 */
class ProductOfCategoryCriteria implements CriteriaInterface
{
    /**
     * @var string|int|array
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
        $category = $this->category;
        if (is_numeric($category)) {
            return $model->where('category_id', $category);
        }
        if (is_string($category)) {
            $workingCategory = explode(',', $category);
        } elseif (is_sequential_array($category)) {
            $workingCategory = $category;
        } else {
            return $model;
        }

        $result = $model;

        foreach ($workingCategory as $cate) {
            if (is_numeric($cate)) {
                $result = $result->where('category_id', $cate);
            } else {
                $result = $result->whereHas('category', fn(Builder $q) => $q->where('slug', $cate));
            }
        }
        return $result;
    }
}
