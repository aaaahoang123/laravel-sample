<?php
/**
 * @Author Hoang Do
 * @Created 1/4/21 3:06 PM
 * @By PhpStorm on Ubuntu
 */

namespace HoangDo\Common\Criteria;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrderByCriteria implements CriteriaInterface
{
    private string $field;
    private string $direction;

    public function __construct(string $field, string $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    /**
     * @param Model|Builder $model
     * @param RepositoryInterface $repository
     * @return mixed|void
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy($this->field, $this->direction);
    }
}
