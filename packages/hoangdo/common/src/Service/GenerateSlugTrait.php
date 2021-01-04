<?php


namespace HoangDo\Common\Service;


use HoangDo\Common\Repository\Repository;
use Illuminate\Support\Str;

trait GenerateSlugTrait
{
    /**
     * @var Repository $_slugRepository
     */
    private Repository $_slugRepository;
    private string $_field = 'slug';

    protected function setSlugRepository($_repository): self
    {
        $this->_slugRepository = $_repository;
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
        if ($this->_slugRepository->exists([$this->_field => $slug]))
            $slug .= '-' . time();
        return $slug;
    }
}
