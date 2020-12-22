<?php


namespace HoangDo\Common\Criteria;

use HoangDo\Common\Enum\CommonStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class HasStatusCriteria.
 *
 * @package namespace App\Repositories\Criteria\Common;
 */
class HasStatusCriteria implements CriteriaInterface
{
    private $status;

    public function __construct($status = CommonStatus::ACTIVE)
    {
        $this->status = $status;
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
        return $model->where('status', $this->status);
    }
}

