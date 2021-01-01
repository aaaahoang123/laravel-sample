<?php


namespace App\Services\Impl;


use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contract\CategoryRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Contract\TagRepository;
use App\Repositories\Criteria\Product\ProductHasSearchCriteria;
use App\Repositories\Criteria\Product\ProductOfCategoryCriteria;
use App\Services\Contract\ProductService;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Request\ValidatedRequest;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductServiceImpl extends SimpleService implements ProductService
{
    private ProductRepository $productRepo;
    private CategoryRepository $categoryRepo;
    private TagRepository $tagRepo;

    public function __construct(
        ProductRepository $productRepo,
        TagRepository $tagRepo,
        CategoryRepository $categoryRepo
    )
    {
        $this->productRepo = $productRepo;
        $this->tagRepo = $tagRepo;
        $this->categoryRepo = $categoryRepo;
        parent::__construct();
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->productRepo;
        $props->useSlug = true;
        $props->identifyField = 'slug';
        $props->listIgnoreStatus = true;
        $props->commonRelations = ['category', 'tags'];
        return $props;
    }

    protected function beforeCreate($instance, ValidatedRequest $req)
    {
        $category = $this->getValidCategory($req->input('category_id'));
        /** @var Product $instance */
        $instance->category()->associate($category);
        $instance->images = implode(',', $req->input('images'));
    }

    protected function beforeEdit($instance, ValidatedRequest $req)
    {
        /** @var Product $instance */
        $category_id = $req->input('category_id');
        if ($instance->category_id != $category_id) {
            $category = $this->getValidCategory($category_id);
            $instance->category()->associate($category);
        }
        $instance->images = implode(',', $req->input('images'));
    }

    protected function afterCreate($instance, ValidatedRequest $req)
    {
        $this->resolveTags($instance, $req);
    }

    protected function afterEdit($instance, ValidatedRequest $req)
    {
        $this->resolveTags($instance, $req);
    }

    /**
     * @param Product $instance
     * @param ProductRequest $req
     */
    private function resolveTags($instance, ProductRequest $req)
    {
        $tags = collect();
        if (is_array($req->tags) && count($req->tags)) {
            $existedTags = $this->tagRepo->findByNameIn($req->tags)->keyBy('name');
            $tags = collect($req->tags)->map(fn($tag) => $existedTags->get($tag)
                ?? $this->tagRepo->create([
                    'name' => $tag,
                    'slug' => Str::lower(Str::slug($tag, ' '))
                ])
            );
        }
        $instance->tags()->sync($tags->map(fn($tag) => $tag->id));
        $instance->setRelation('tags', $tags);
    }

    protected function queryToCriteria(array $query): array
    {
        $criteria = [];
        if ($search = $query['search'] ?? null)
            $criteria[] = new ProductHasSearchCriteria($search);

        if ($category = $query['category'] ?? null)
            $criteria[] = new ProductOfCategoryCriteria($category);

        if ($status = $query['status'] ?? null)
            $criteria[] = new HasStatusCriteria($status);

        return $criteria;
    }

    private function getValidCategory($id): Category
    {
        /** @var Category $category */
        $category = $this->categoryRepo->find($id);
        if (!$category->isActive()) {
            throw new BadRequestHttpException(__('messages.invalid_category'));
        }
        return $category;
    }
}
