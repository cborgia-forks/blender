<?php

namespace App\Repositories;

use App\Models\NewsItem;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class NewsItemRepository
{
    public function getAll(): Collection
    {
        return NewsItem::orderBy('publish_date', 'desc')->nonDraft()->get();
    }

    public function getLatest(int $amount): Collection
    {
        return NewsItem::orderBy('publish_date', 'desc')
            ->online()
            ->take($amount)
            ->get();
    }

    /**
     * @param \App\Models\NewsItem $newsItem
     *
     * @return \App\Models\NewsItem|null
     */
    public function findNext(NewsItem $newsItem)
    {
        return NewsItem::online()
            ->where('publish_date', '>', $newsItem->publish_date)
            ->orderBy('publish_date', 'desc')
            ->first();
    }

    /**
     * @param \App\Models\NewsItem $newsItem
     *
     * @return \App\Models\NewsItem|null
     */
    public function findPrevious(NewsItem $newsItem)
    {
        return NewsItem::online()
            ->where('publish_date', '<', $newsItem->publish_date)
            ->orderBy('publish_date', 'desc')
            ->first();
    }

    public function paginate(int $perPage): Paginator
    {
        return NewsItem::online()->paginate($perPage);
    }
}
