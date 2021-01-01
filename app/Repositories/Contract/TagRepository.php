<?php

namespace App\Repositories\Contract;

use App\Models\Tag;
use HoangDo\Common\Repository\Repository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface TagRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface TagRepository extends Repository
{
    /**
     * @param array|string[] $names
     * @return Collection|Tag[]
     */
    public function findByNameIn($names);
}
