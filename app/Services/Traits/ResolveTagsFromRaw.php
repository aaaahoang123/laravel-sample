<?php


namespace App\Services\Traits;


use App\Repositories\Contract\TagRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ResolveTagsFromRaw
{
    private function getTagRepo(): TagRepository
    {
        return app(TagRepository::class);
    }

    public function resolveTagFromRaw($rawTags): Collection
    {
        $tags = collect();
        if (is_array($rawTags) && count($rawTags)) {
            $existedTags = $this->getTagRepo()->findByNameIn($rawTags)->keyBy('name');
            $tags = collect($rawTags)->map(fn($tag) => $existedTags->get($tag)
                ?? $this->getTagRepo()->create([
                    'name' => $tag,
                    'slug' => Str::lower(Str::slug($tag, ' '))
                ])
            );
        }
        return $tags;
//        $instance->tags()->sync($tags->map(fn($tag) => $tag->id));
//        $instance->setRelation('tags', $tags);
    }
}
