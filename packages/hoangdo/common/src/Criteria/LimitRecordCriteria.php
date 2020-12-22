<?php


namespace HoangDo\Common\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LimitRecordCriteria implements CriteriaInterface
{
    private $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->take($this->limit);
    }
}
