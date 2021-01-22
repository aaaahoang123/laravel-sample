<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Repository\RepositoryEloquent;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\SystemConfigRepository;
use App\Models\SystemConfig;

/**
 * Class SystemConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class SystemConfigRepositoryEloquent extends RepositoryEloquent implements SystemConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SystemConfig::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
