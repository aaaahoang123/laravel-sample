<?php


namespace HoangDo\Common\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WhereCriteria implements CriteriaInterface
{
    private string $field;
    /**
     * @var string|int|mixed|null
     */
    private $operator;
    private $value;
    public function __construct($field, $operator, $value = null)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where($this->field, $this->operator, $this->value);
    }
}
