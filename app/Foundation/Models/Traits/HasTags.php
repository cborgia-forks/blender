<?php

namespace App\Foundation\Models\Traits;

use App\Models\Enums\TagType;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tagsWithType(TagType $type): Collection
    {
        return $this->tags->filter(function (Tag $tag) use ($type) {
            return $tag->hasType($type);
        });
    }

    public static function getAllOnlineGroupedByTagCategory(TagType $tagType): Collection
    {
        $tags = Tag::getWithType($tagType);

        return static::allOnline()
            ->groupBy(function (Model $model) use ($tagType) {
                $firstTag = $model->tagsWithType($tagType)->first();

                if (!$firstTag) {
                    return 0;
                }

                return $firstTag->id;
            })
            ->map(function ($tagIdsWithModels, int $tagId) use ($tags) {
                return [
                    'tag' => $tags->get($tagId),
                    'models' => collect($tagIdsWithModels)->values(),
                ];
            })
            ->sortBy(function (array $tagsAndModels) {
                return $tagsAndModels['tag']->order_column;
            })
            ->values();
    }
}
