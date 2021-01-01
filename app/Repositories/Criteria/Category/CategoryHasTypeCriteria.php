<?php

namespace App\Repositories\Criteria\Category;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CategoryHasTypeCriteria.
 *
 * @package namespace App\Repositories\Criteria\Category;
 */
class CategoryHasTypeCriteria implements CriteriaInterface
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
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
        return $model->where('type', $this->type);
    }
}
