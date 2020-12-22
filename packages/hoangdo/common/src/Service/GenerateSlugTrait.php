<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Repository\Repository;
use Illuminate\Support\Str;

trait GenerateSlugTrait
{
    /**
     * @var Repository $_repository
     */
    private Repository $_repository;
    private string $_field = 'slug';

    protected function setSlugRepository($_repository): self
    {
        $this->_repository = $_repository;
        return $this;
    }

    protected function setSlugField($_field): self
    {
        $this->_field = $_field;
        return $this;
    }

    private function generateSlug(string $name): string {
        $slug = Str::slug($name);
        $slug = Str::lower($slug);
        if ($this->_repository->exists([$this->_field => $slug]))
            $slug .= '-' . time();
        return $slug;
    }
}
