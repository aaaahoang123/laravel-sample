<?php


namespace HoangDo\Common\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class HasFromCriteria implements CriteriaInterface
{

    private $from;

    public function __construct($from)
    {
        $this->from = $from;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('created_at', '>=' ,$this->from);
    }
}
