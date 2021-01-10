<?php


namespace App\Services\Impl;


use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contract\CategoryRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Contract\TagRepository;
use App\Repositories\Criteria\Product\ProductHasSearchCriteria;
use App\Repositories\Criteria\Product\BelongToCategoryCriteria;
use App\Services\Contract\ProductService;
use App\Services\Traits\ResolveCategoryTree;
use App\Services\Traits\ResolveTagsFromRaw;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Request\ValidatedRequest;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductServiceImpl extends SimpleService implements ProductService
{
    use ResolveTagsFromRaw, ResolveCategoryTree;

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
            $this->beforeCreate($instance, $req);
        } else {
            $instance->images = implode(',', $req->input('images'));
        }
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
        $tags = $this->resolveTagFromRaw($req->tags);
        $instance->tags()->sync($tags->map(fn($tag) => $tag->id));
        $instance->setRelation('tags', $tags);
    }

    protected function queryToCriteria(array $query): array
    {
        $criteria = [];
        if ($search = $query['search'] ?? null)
            $criteria[] = new ProductHasSearchCriteria($search);

        if ($category = $query['category'] ?? null) {
            $category_ids = $this->getExpandedNodeIdsFromCategory($category);
            $criteria[] = new BelongToCategoryCriteria($category_ids);
        }

        if ($status = $query['status'] ?? null)
            $criteria[] = new HasStatusCriteria($status);

        return $criteria;
    }

    private function getValidCategory($id): Category
    {
        /** @var Category $category */
        $category = $this->categoryRepo->find($id);
        if (!$category->isActive()) {
            throw new BadRequestHttpException(__('messages.category_has_been_banned'));
        }
        if (!$category->isProductCategory()) {
            throw new BadRequestHttpException(__('messages.category_is_not_product_type', ['category' => $category->name]));
        }
        return $category;
    }
}
