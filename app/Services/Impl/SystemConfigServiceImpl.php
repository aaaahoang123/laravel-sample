<?php


namespace App\Services\Impl;


use App\Enums\Type\SystemConfigDataType;
use App\Http\Requests\SystemConfigRequest;
use App\Models\SystemConfig;
use App\Repositories\Contract\SystemConfigRepository;
use App\Services\Contract\SystemConfigService;
use Illuminate\Support\Collection;

class SystemConfigServiceImpl implements SystemConfigService
{
    private SystemConfigRepository $configRepository;

    public function __construct(SystemConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function findAll(): Collection
    {
        return $this->configRepository->all();
    }

    public function createOrEdit($id, SystemConfigRequest $req): SystemConfig
    {
        $config = $this->configRepository->findWhere(compact('id'))->first();
        if (!$config) {
            $config = new SystemConfig();
            $config->id = $id;
        }
        $config->data_type = $req->data_type;
        if ($req->data_type == SystemConfigDataType::JSON) {
            $config->value = json_encode($req->value);
        } else {
            $config->value = $req->value;
        }
        return $this->configRepository->save($config);
    }
}
