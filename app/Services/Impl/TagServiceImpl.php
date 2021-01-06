<?php


namespace App\Services\Impl;


use App\Repositories\Contract\TagRepository;
use App\Repositories\Criteria\Tag\TagHasSearchCriteria;
use App\Services\Contract\TagService;
use HoangDo\Common\Criteria\OrderByCreatedAtDescCriteria;
use HoangDo\Common\Criteria\OrderByCriteria;
use HoangDo\Common\Service\SimpleService;
use HoangDo\Common\Service\SimpleServiceProps;

class TagServiceImpl extends SimpleService implements TagService
{
    private TagRepository $tagRepo;

    public function __construct(
        TagRepository $tagRepo
    )
    {
        $this->tagRepo = $tagRepo;
    }

    function getInitialProps(): SimpleServiceProps
    {
        $props = new SimpleServiceProps();
        $props->repository = $this->tagRepo;
        $props->listIgnoreStatus = true;
        return $props;
    }

    protected function queryToCriteria(array $query): array
    {
        $criteria = [
            new OrderByCriteria('last_used_at', 'desc')
        ];

        if ($search = $query['search'] ?? null) {
            $criteria[] = new TagHasSearchCriteria($search);
        }

        return $criteria;
    }
}
