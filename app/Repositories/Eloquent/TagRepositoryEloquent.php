<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Repository\RepositoryEloquent;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\TagRepository;
use App\Models\Tag;

/**
 * Class TagRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class TagRepositoryEloquent extends RepositoryEloquent implements TagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findByNameIn($names)
    {
        return $this->makeModel()
            ->newQuery()
            ->whereIn('name', $names)
            ->get();
    }

}
