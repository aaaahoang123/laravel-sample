<?php
/**
 * @Author Hoang Do
 * @Created 1/4/21 5:21 PM
 * @By PhpStorm on Ubuntu
 */

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Services\Contract\BannerService;

class BannerController extends Controller
{
    private BannerService $bannerService;

    public function __construct(
        BannerService $bannerService
    )
    {
        $this->bannerService = $bannerService;
    }

    public function create(BannerRequest $req)
    {
        return $this->bannerService->create($req);
    }

    public function list()
    {
        return $this->bannerService->listAll();
    }

    public function single($id)
    {
        return $this->bannerService->single($id);
    }

    public function edit($id, BannerRequest $req)
    {
        return $this->bannerService->edit($id, $req);
    }

    public function delete($id)
    {
        return $this->bannerService->delete($id);
    }
}
