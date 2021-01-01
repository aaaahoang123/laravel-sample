<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface Service
{
    /**
     * @param ValidatedRequest $req
     * @return Model
     */
    public function create(ValidatedRequest $req);

    /**
     * @param array|mixed|null $query
     * @param int|null $limit
     * @return Collection|Model[]|LengthAwarePaginator
     */
    public function listAll($query = null, $limit = null);

    /**
     * @param $id
     * @return Model
     */
    public function single($id);

    /**
     * @param $id
     * @param ValidatedRequest $req
     * @return Model
     */
    public function edit($id, ValidatedRequest $req);

    /**
     * @param $id
     * @return Model
     */
    public function delete($id);
}
