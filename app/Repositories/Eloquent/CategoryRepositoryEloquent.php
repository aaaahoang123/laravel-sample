<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Repository\RepositoryEloquent;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\CategoryRepository;
use App\Models\Category;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CategoryRepositoryEloquent extends RepositoryEloquent implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @inheritDoc
     */
    public function findAllCategories($query = null)
    {
        /** @var Collection $parents */
        $parents = $this->makeModel()->newQuery()
            ->where($query ?? [])
            ->whereNull('parent_id')
            ->where('status', CommonStatus::ACTIVE)
            ->get();

        $temp_parents = $parents;

        do {
            $children = $this->findChildrenOfParents($temp_parents);
            $this->mapChildrenToParents($children, $temp_parents);
            $temp_parents = $children;
        } while($children->count());

        return $parents;
    }

    /**
     * @param Collection $parents
     * @return Collection
     * @throws RepositoryException
     */
    private function findChildrenOfParents($parents): Collection
    {
        $parent_ids = $parents->map(function ($parent) {
            return $parent->id;
        })->toArray();

        return $this->makeModel()
            ->newQuery()
            ->where('status', CommonStatus::ACTIVE)
            ->whereIn('parent_id', $parent_ids)
            ->get();
    }

    /**
     * @param Collection $parents
     * @param Collection $children
     */
    private function mapChildrenToParents($children, $parents) {
        if (!$children->count())
            return;
        $parents_map = [];
        foreach ($parents as $parent)
            $parents_map[$parent->id] = $parent;

        foreach ($children as $child) {
            if (!empty($parents_map[$child->parent_id])) {
                /** @var Category $parent */
                $parent = $parents_map[$child->parent_id];
                if ($parent->relationLoaded('children')) {
                    $mapping_children = $parent->children;
                } else {
                    $mapping_children = collect();
                    $parent->setRelation('children', $mapping_children);
                }
                $mapping_children->add($child);
            }
        }
    }

    public function findAllChildNodesOfCategory(Category $category): Collection
    {
        $path = $category->path;
        return $this->model->newQuery()
            ->where('path', 'like', "$path.%")
            ->get();
    }
}
