<?php
namespace App\Feed;

use App\Entity\Category;
use App\Entity\FeedItem;

/**
 * Get feeds' category.
 */
class CategoryFeedItemGetter
{
    /**
     * Get the feeds of a category, included subcategories.
     *
     * @param \App\Entity\Category $category The category
     * @param bool                 $read     The item read
     *
     * @return \App\Entity\FeedItem[] The feed items
     */
    public function get(Category $category, $read = null) : array
    {
        $feeds = $this->getCategoryTreeFeedItems($category, $read);
        usort($feeds, [$this, 'orderCategories']);

        return $feeds;
    }

    /**
     * Get the item count of a category, included subcategories.
     *
     * @param \App\Entity\Category $category The category
     * @param bool                 $read     The item read
     *
     * @return int The count
     */
    public function count(Category $category, $read = null) : int
    {
        $feeds = $this->getCategoryTreeFeedItems($category, $read);

        return count($feeds);
    }

    /**
     * Get the feed items of a category, included subcategories.
     *
     * @param \App\Entity\Category $category The category
     * @param bool                 $read     The item read
     *
     * @return \App\Entity\FeedItem[] The feed items
     */
    private function getCategoryTreeFeedItems(Category $category, $read = null, array $feeds = []) : array
    {
        $feedItems = array_merge($feeds, $category->getFeedItems($read));

        foreach ($category->getChildren() as $subCategory) {
            $feedItems = $this->getCategoryTreeFeedItems($subCategory, $read, $feedItems);
        }

        return $feedItems;
    }

    /**
     * Order an array of feed items.
     *
     * @param \App\Entity\FeedItem $item1 The item 1
     * @param \App\Entity\FeedItem $item2 The item 2
     * @return int The order
     */
    private function orderCategories(FeedItem $item1, FeedItem $item2)
    {
        if ($item1->getDate() < $item2->getDate()) {
            return -1;
        }

        if ($item1->getDate() > $item2->getDate()) {
            return 1;
        }

        return 0;
    }
}
