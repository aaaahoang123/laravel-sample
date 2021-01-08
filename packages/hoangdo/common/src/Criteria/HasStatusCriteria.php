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
class HasStatusCriteria extends WhereCriteria
{
    public function __construct($status = CommonStatus::ACTIVE)
    {
        parent::__construct('status', $status);
    }
}

