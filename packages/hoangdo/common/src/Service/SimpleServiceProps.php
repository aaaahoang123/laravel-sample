<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Repository\Repository;

class SimpleServiceProps
{
    public Repository $repository;
    public bool $useSlug = false;
    public string $slugField = 'slug';
    /**
     * Use this field to generate the slug.
     *
     * @var string $titleField
     */
    public string $titleField = 'name';
    public bool $listIgnoreStatus = false;
    public string $identifyField = 'id';
    public string $statusField = 'status';
    /**
     * @var array|null $commonRelations
     */
    public $commonRelations;
}
