<?php


namespace App\Services\Contract;


use HoangDo\Common\Service\Service;
use Illuminate\Database\Eloquent\Collection;

interface ProductService extends Service
{
    public function statisticsInYears(): Collection;
    public function countActiveProductThisMonth(): int;
    public function countByStatus($status): int;
}
