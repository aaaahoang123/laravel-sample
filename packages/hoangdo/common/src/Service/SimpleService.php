<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Criteria\WhereCriteria;
use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Model\HasCreatorInfo;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;

abstract class SimpleService implements Service
{
    use GenerateSlugTrait;

    private $_props = null;

    abstract function getInitialProps(): SimpleServiceProps;

    private function _props(): SimpleServiceProps
    {
        if (!$this->_props) {
            $props = $this->getInitialProps();
            $this->_props = $props;
            if ($props->useSlug) {
                $this->setSlugRepository($props->repository)
                    ->setSlugField($props->slugField);
            }
        }
        return $this->_props;
    }

    public function create(ValidatedRequest $req)
    {
        $modelClass = $this->_props()->repository->model();

        /** @var Model $instance */
        $instance = new $modelClass($req->filteredData());

        $this->resolveCreator($instance, $req);
        if ($this->_props()->useSlug) {
            $slug = $this->generateSlug($req->get($this->_props()->titleField));
            $instance->setAttribute($this->_props()->slugField, $slug);
        }
        $this->beforeCreate($instance, $req);
        $instance = $this->_props()->repository->save($instance);
        $this->afterCreate($instance, $req);
        return $instance;
    }

    protected function resolveCreator($instance, ValidatedRequest $req) {
        $traits = class_uses_recursive($instance);
        if (in_array(HasCreatorInfo::class, $traits)) {
            $creator = $req->user();
            /** @var HasCreatorInfo $instance */
            $instance->created_by()->associate($creator);
            $instance->updated_by()->associate($creator);
        }
    }

    public function listAll($query = null, $limit = null)
    {
        $repository = $this->_props()->repository;
        if (!$this->_props()->listIgnoreStatus) {
            $repository->pushCriteria(new HasStatusCriteria());
        }

        if (is_array($query)) {
            $criteria = $this->queryToCriteria($query);
            $repository->pushCriteria($criteria);
        }

        if ($relations = $this->_props()->commonRelations) {
            $repository->with($relations);
        }

        if ($limit) {
            return $repository->paginate($limit);
        }
        return $repository->all();
    }

    public function single($id)
    {

        $repository = $this->_props()->repository;
        $repository->pushCriteria(new WhereCriteria($this->_props()->identifyField, $id));
        if ($relations = $this->_props()->commonRelations) {
            $repository->with($relations);
        }
        return $repository->firstOrFail();
    }

    public function edit($id, ValidatedRequest $req)
    {
        $instance = $this->single($id);
        $instance->fill($req->filteredData());
        $traits = class_uses_recursive($instance);
        if (in_array(HasCreatorInfo::class, $traits)) {
            $editor = $req->user();
            /** @var HasCreatorInfo $instance */
            $instance->updated_by()->associate($editor);
        }
        if ($this->_props()->useSlug) {
            $oldName = $instance->getOriginal($this->_props()->titleField);
            $newName = $req->input($this->_props()->titleField);
            if ($newName && $oldName != $newName) {
                $newSlug = $this->generateSlug($newName);
                $instance->setAttribute($this->_props()->slugField, $newSlug);
            }
        }

        $this->beforeEdit($instance, $req);
        $instance = $this->_props()->repository->save($instance);
        $this->afterEdit($instance, $req);

        return $instance;
    }

    protected function beforeEdit($instance, ValidatedRequest $req)
    {
    }

    protected function beforeCreate($instance, ValidatedRequest $req)
    {
    }

    protected function afterCreate($instance, ValidatedRequest $req)
    {
    }

    protected function afterEdit($instance, ValidatedRequest $req)
    {
    }

    /**
     * @param array|mixed $query
     * @return array|CriteriaInterface[]|string[]
     */
    protected function queryToCriteria(array $query): array
    {
        return [];
    }

    public function delete($id)
    {
        $instance = $this->single($id);
        $instance->setAttribute($this->_props()->statusField, CommonStatus::INACTIVE);
        return $this->_props()->repository->save($instance);
    }
}
