<?php


namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\SystemConfigRequest;
use App\Services\Contract\SystemConfigService;

class SystemConfigController extends Controller
{
    private SystemConfigService $configService;

    public function __construct(SystemConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function list() {
        return $this->configService->findAll();
    }

    public function editOrCreate($id, SystemConfigRequest $req) {
        return $this->configService->createOrEdit($id, $req);
    }
}
