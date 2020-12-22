<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Request\ValidatedRequest;
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
     * @return Collection|Model[]
     */
    public function listAll();

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
