<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Criteria\HasStatusCriteria;
use HoangDo\Common\Criteria\WhereCriteria;
use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Model\HasCreatorInfo;
use HoangDo\Common\Request\ValidatedRequest;
use Illuminate\Database\Eloquent\Model;

abstract class SimpleService implements Service
{
    use GenerateSlugTrait;

    private SimpleServiceProps $_props;

    abstract function getInitialProps(): SimpleServiceProps;

    protected function __construct()
    {
        $props = $this->getInitialProps();
        $this->_props = $props;
        if ($props->useSlug) {
            $this->setSlugRepository($props->repository)
                ->setSlugField($props->slugField);
        }
    }

    public function create(ValidatedRequest $req)
    {
        $modelClass = $this->_props->repository->model();

        /** @var Model $instance */
        $instance = new $modelClass($req->filteredData());

        $traits = class_uses_recursive($instance);
        if (in_array(HasCreatorInfo::class, $traits)) {
            $creator = $req->user();
            /** @var HasCreatorInfo $instance */
            $instance->created_by()->associate($creator);
            $instance->updated_by()->associate($creator);
        }
        if ($this->_props->useSlug) {
            $slug = $this->generateSlug($req->get($this->_props->titleField));
            $instance->setAttribute($this->_props->slugField, $slug);
        }
        return $this->_props->repository->save($instance);
    }

    public function listAll()
    {
        if (!$this->_props->listIgnoreStatus) {
            $this->_props->repository->pushCriteria(new HasStatusCriteria());
        }

        return $this->_props->repository->all();
    }

    public function single($id)
    {
        $this->_props->repository->pushCriteria(new WhereCriteria($this->_props->identifyField, $id));
        return $this->_props->repository->first();
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
        if ($this->_props->useSlug) {
            $oldName = $instance->getOriginal($this->_props->titleField);
            $newName = $req->input($this->_props->titleField);
            if ($newName && $oldName != $newName) {
                $newSlug = $this->generateSlug($newName);
                $instance->setAttribute($this->_props->slugField, $newSlug);
            }
        }

        return $this->_props->repository->save($instance);
    }

    public function delete($id)
    {
        $instance = $this->single($id);
        $instance->setAttribute($this->_props->statusField, CommonStatus::INACTIVE);
        return $this->_props->repository->save($instance);
    }
}
