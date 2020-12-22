<?php


namespace HoangDo\Common\Repository;


use Prettus\Repository\Eloquent\BaseRepository;

abstract class RepositoryEloquent extends BaseRepository implements Repository
{
    public function exists($id)
    {
        $this->applyCriteria();
        $this->applyScope();
        if (is_array($id)) {
            $model = $this->model->where($id);
        } else {
            $model = $this->model->where('id', $id);
        }
        $result = $model->exists();
        $this->resetModel();
        return $result;
    }

    public function pushCriteria($criteria)
    {
        if (is_array($criteria)) {
            $result = $this;
            foreach ($criteria as $c) {
                $result = parent::pushCriteria($c);
            }
            return $result;
        }
        return parent::pushCriteria($criteria);
    }

    /**
     * @inheritDoc
     */
    public function firstOrFail($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->firstOrFail($columns);

        $this->resetModel();

        return $this->parserResult($results);
    }

    public function findBySlug($slug, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
            ->where(compact('slug'))
            ->firstOrFail($columns);

        $this->resetModel();

        return $this->parserResult($results);
    }

    /**
     * @inheritDoc
     */
    public function save($object)
    {
        $isCreate = !$object->getKey();
        $object->save();
        if ($isCreate) {
            $object->refresh();
        }
        return $object;
    }

    public function sum($column)
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->sum($column);

        $this->resetModel();

        return $results;
    }
}
