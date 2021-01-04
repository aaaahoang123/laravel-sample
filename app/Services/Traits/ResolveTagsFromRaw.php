<?php


namespace App\Services\Traits;


use App\Models\Tag;
use App\Repositories\Contract\TagRepository;
use Carbon\Carbon;
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
            $now = Carbon::now();
            $tags = collect($rawTags)->map(function($tag) use ($existedTags, $now) {
                $tag = $existedTags->get($tag)
                ?? new Tag([
                    'name' => $tag,
                    'slug' => Str::lower(Str::slug($tag, ' '))
                ]);
                $tag->last_used_at = $now;
                return $this->getTagRepo()->save($tag);
            });
        }
        return $tags;
    }
}
