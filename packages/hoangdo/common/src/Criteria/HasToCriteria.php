<?php


namespace HoangDo\Common\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class HasToCriteria implements CriteriaInterface
{
    private $to;

    public function __construct($to)
    {
        $this->to = $to;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('created_at', '<=', $this->to);
    }
}
