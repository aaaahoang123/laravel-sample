<?php

namespace App\Repositories\Contract;

use App\Models\Category;
use HoangDo\Common\Repository\Repository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CategoryRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface CategoryRepository extends Repository
{
    /**
     * @return Collection|Category[]
     */
    public function findAllCategories();
}
