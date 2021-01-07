<?php


namespace App\Services\Impl;


use App\Models\Category;
use App\Repositories\Contract\CategoryRepository;
use App\Services\Contract\CategoryService;
use HoangDo\Common\Request\ValidatedRequest;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;
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

    public function listAll($query = null, $limit = null)
    {
        return $this->categoryRepo->findAllCategories($query);
    }

    protected function beforeEdit($instance, ValidatedRequest $req)
    {
        /** @var Category $instance */
        if ($instance->is_system){
            throw new BadRequestHttpException(__('messages.system_category_can_not_edit'));
        }
        if (is_null($req->get('parent_id'))) {
            $instance->parent_id = null;
        }
        if ($req->get('parent_id') == $instance->id) {
            throw new BadRequestHttpException(__('messages.category_can_not_be_parent_of_it_self'));
        }
    }
}
