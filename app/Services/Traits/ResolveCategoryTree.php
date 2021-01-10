<?php
/**
 * @author Hoang Do
 * @date  1/10/2021 10:35 PM
 * @used PhpStorm
 */

namespace App\Services\Traits;


use App\Models\Category;
use App\Repositories\Contract\CategoryRepository;
use Illuminate\Support\Collection;

trait ResolveCategoryTree
{
    private function getCategoryRepository(): CategoryRepository {
        return app(CategoryRepository::class);
    }

    public function getExpandedNodeIdsFromCategory($category): Collection {
        if (is_numeric($category)) {
            $category = $this->getCategoryRepository()->find($category);
        } elseif (is_string($category)) {
            $category = $this->getCategoryRepository()->findBySlug($category);
        } elseif (!$category instanceof Category) {
            return collect();
        }
        $children = $this->getCategoryRepository()
            ->findAllChildNodesOfCategory($category)
            ->map(fn($child) => $child->id);
        $children->prepend($category->id);
        return $children;
    }
}
