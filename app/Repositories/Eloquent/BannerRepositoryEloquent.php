<?php
/**
 * @Author Hoang Do
 * @Created 1/4/21 4:52 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Repositories\Eloquent;


use App\Models\Banner;
use App\Repositories\Contract\BannerRepository;
use HoangDo\Common\Repository\RepositoryEloquent;

class BannerRepositoryEloquent extends RepositoryEloquent implements BannerRepository
{
    public function model()
    {
        return Banner::class;
    }
}
