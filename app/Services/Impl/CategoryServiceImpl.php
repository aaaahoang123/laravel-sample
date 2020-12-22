<?php


namespace App\Services\Impl;


use App\Repositories\Contract\CategoryRepository;
use App\Services\Contract\CategoryService;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;

class CategoryServiceImpl extends SimpleService implements CategoryService
{
    private CategoryRepository $categoryRepo;
    public function __construct(
        CategoryRepository $categoryRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
        parent::__construct();
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->categoryRepo;
        $props->useSlug = true;
        $props->identifyField = 'slug';

        return $props;
    }

    public function listAll()
    {
        return $this->categoryRepo->findAllCategories();
    }
}
