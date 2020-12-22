<?php


namespace HoangDo\Common\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WithCountRelationCriteria implements CriteriaInterface
{

    private $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->withCount($this->relation);
    }
}
