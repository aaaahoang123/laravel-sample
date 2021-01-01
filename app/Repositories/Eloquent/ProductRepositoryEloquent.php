<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Repository\RepositoryEloquent;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProductRepository;
use App\Models\Product;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProductRepositoryEloquent extends RepositoryEloquent implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
