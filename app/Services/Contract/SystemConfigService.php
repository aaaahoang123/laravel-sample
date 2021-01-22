<?php


namespace App\Services\Contract;


use App\Http\Requests\SystemConfigRequest;
use App\Models\SystemConfig;
use Illuminate\Support\Collection;

interface SystemConfigService
{
    public function findAll(): Collection;
    public function createOrEdit($id, SystemConfigRequest $req): SystemConfig;
}
