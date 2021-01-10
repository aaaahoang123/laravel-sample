<?php


namespace App\Services\Impl;


use App\Models\Category;
use App\Repositories\Contract\CategoryRepository;
use App\Services\Contract\CategoryService;
use HoangDo\Common\Request\ValidatedRequest;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CategoryServiceImpl extends SimpleService implements CategoryService
{
    private CategoryRepository $categoryRepo;
    public function __construct(
        CategoryRepository $categoryRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->categoryRepo;
        $props->useSlug = true;
        $props->identifyField = 'slug';

        return $props;
    }

    protected function beforeCreate($instance, ValidatedRequest $req)
    {
        /** @var Category $instance */
        if ($parent_id = $req->input('parent_id')) {
            $parent = $this->categoryRepo->find($parent_id);
            $instance->parent()->associate($parent);
        }
    }

    protected function afterCreate($instance, ValidatedRequest $req)
    {
        /** @var Category $instance */
        $instance->path = '';
        if ($instance->parent) {
            $instance->path .= $instance->parent->path . '.';
        }
        $instance->path .= $instance->id;
        $this->categoryRepo->save($instance);
    }

    public function listAll($query = null, $limit = null)
    {
        return $this->categoryRepo->findAllCategories($query);
    }

    protected function beforeEdit($instance, ValidatedRequest $req)
    {
        /** @var Category $instance */
        if ($instance->is_system) {
            throw new BadRequestHttpException(__('messages.system_category_can_not_edit'));
        }
        $parent_id = $req->input('parent_id');
        if ($parent_id == $instance->id) {
            throw new BadRequestHttpException(__('messages.category_can_not_be_parent_of_it_self'));
        }
        if ($parent_id != $instance->parent_id) {
            if (is_null($parent_id)) {
                $instance->parent()->disassociate();
                $newPathPrefix = $instance->id;
            } else {
                $newParent = $this->categoryRepo->find($parent_id);
                $instance->parent()->associate($newParent);
                $newPathPrefix = $newParent->path . '.' . $instance->id;
            }
            $this->resolvePathForAllChildNodes($instance, $newPathPrefix);
            $instance->path = $newPathPrefix;
        }
    }

    private function resolvePathForAllChildNodes($instance, $newPathPrefix) {
        $childNodes = $this->categoryRepo->findAllChildNodesOfCategory($instance);
        foreach ($childNodes as $child) {
            /** @var Category $child */
            $child->path = Str::replaceFirst($instance->path, $newPathPrefix, $child->path);
            $this->categoryRepo->save($child);
        }
    }
}
