<?php

namespace HoangDo\Common\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithRelationsCriteria.
 *
 * @package namespace App\Repositories\Criteria\Common;
 */
class WithRelationsCriteria implements CriteriaInterface
{
    protected $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with($this->relation);
    }
}
