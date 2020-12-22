<?php


namespace HoangDo\Common\Repository;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface Repository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * @param int|string|array $id
     * @return bool
     */
    public function exists($id);

    /**
     * Count results of repository
     *
     * @param array $where
     * @param string $columns
     *
     * @return int
     */
    public function count(array $where = [], $columns = '*');

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*']);

    public function firstOrFail($columns = ['*']);

    /**
     * @param string $slug
     * @param array $column
     * @return mixed
     */
    public function findBySlug($slug, $column = ['*']);

    /**
     * @param Model $object
     * @return mixed
     */
    public function save($object);

    /**
     * @param $column
     * @return int
     */
    public function sum($column);
}
