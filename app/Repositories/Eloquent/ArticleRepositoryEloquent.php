<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Repository\RepositoryEloquent;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ArticleRepository;
use App\Models\Article;

/**
 * Class ArticleRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ArticleRepositoryEloquent extends RepositoryEloquent implements ArticleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
