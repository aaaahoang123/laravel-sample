<?php
/**
 * @Author Hoang Do
 * @Created 1/4/21 4:53 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Services\Impl;


use App\Repositories\Contract\BannerRepository;
use App\Services\Contract\BannerService;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;

class BannerServiceImpl extends SimpleService implements BannerService
{
    private BannerRepository $bannerRepo;

    public function __construct(
        BannerRepository $bannerRepo
    )
    {
        $this->bannerRepo = $bannerRepo;
        parent::__construct();
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->bannerRepo;
        return $props;
    }
}
