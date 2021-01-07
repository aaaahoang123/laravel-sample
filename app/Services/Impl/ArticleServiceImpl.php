<?php


namespace App\Services\Impl;


use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\Contract\ArticleRepository;
use App\Repositories\Contract\CategoryRepository;
use App\Repositories\Criteria\Article\ArticleHasSearchCriteria;
use App\Repositories\Criteria\Article\ArticleOfCategoryCriteria;
use App\Services\Contract\ArticleService;
use App\Services\Traits\ResolveTagsFromRaw;
use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Request\ValidatedRequest;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ArticleServiceImpl extends SimpleService implements ArticleService
{
    use ResolveTagsFromRaw;

    private ArticleRepository $articleRepo;
    private CategoryRepository $categoryRepo;

    public function __construct(
        ArticleRepository $articleRepo,
        CategoryRepository $categoryRepo
    )
    {
        $this->articleRepo = $articleRepo;
        $this->categoryRepo = $categoryRepo;
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->articleRepo;
        $props->identifyField = 'slug';
        $props->listIgnoreStatus = true;
        $props->useSlug = true;
        $props->commonRelations = ['tags'];

        return $props;
    }

    protected function beforeCreate($instance, ValidatedRequest $req)
    {
        $category = $this->getValidCategory($req->input('category_id'));
        /** @var Article $instance */
        $instance->category()->associate($category);
    }

    protected function beforeEdit($instance, ValidatedRequest $req)
    {
        /** @var Article $instance */
        $category_id = $req->input('category_id');
        if ($instance->category->is_system) {
            $instance->name = $instance->getOriginal('name');
            $instance->slug = $instance->getOriginal('slug');
        } elseif ($instance->category_id != $category_id) {
            $this->beforeCreate($instance, $req);
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

    protected function queryToCriteria(array $query): array
    {
        $criteria = [];
        if ($search = $query['search'] ?? null)
            $criteria[] = new ArticleHasSearchCriteria($search);

        if ($category = $query['category'] ?? null)
            $criteria[] = new ArticleOfCategoryCriteria($category);

        if ($status = $query['status'] ?? null)
            $criteria[] = new HasStatusCriteria($status);

        return $criteria;
    }

    /**
     * @param Article $instance
     * @param ArticleRequest $req
     */
    private function resolveTags($instance, ArticleRequest $req)
    {
        $tags = $this->resolveTagFromRaw($req->tags);
        $instance->tags()->sync($tags->map(fn($tag) => $tag->id));
        $instance->setRelation('tags', $tags);
    }

    private function getValidCategory($id): Category
    {
        /** @var Category $category */
        $category = $this->categoryRepo->find($id);
        if (!$category->isActive()) {
            throw new BadRequestHttpException(__('messages.category_has_been_banned'));
        }
        if (!$category->isArticleCategory()) {
            throw new BadRequestHttpException(__('messages.category_is_not_article_type', ['category' => $category->name]));
        }
        return $category;
    }
}
