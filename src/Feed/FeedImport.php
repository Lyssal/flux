<?php
namespace App\Feed;

use App\Entity\Feed;
use DateTime;
use Lyssal\Doctrine\Orm\Manager\EntityManager;
use Lyssal\Encoding\Utf8;
use SimplePie;
use SimplePie_Item;

/**
 * Import the new feed items.
 */
class FeedImport
{
    /**
     * @var \Lyssal\Doctrine\Orm\Manager\EntityManager The Feed manager
     */
    private $feedManager;

    /**
     * @var \Lyssal\Doctrine\Orm\Manager\EntityManager The FeedItem manager
     */
    private $feedItemManager;

    /**
     * @var string The cache directory
     */
    private $cacheDir;


    /**
     * FeedImport constructor.
     *
     * @param \Lyssal\Doctrine\Orm\Manager\EntityManager $feedManager     The Feed manager
     * @param \Lyssal\Doctrine\Orm\Manager\EntityManager $feedItemManager The FeedItem manager
     * @param string                                     $cacheDir        The cache directory
     */
    public function __construct(EntityManager $feedManager, EntityManager $feedItemManager, $cacheDir)
    {
        $this->feedManager = $feedManager;
        $this->feedItemManager = $feedItemManager;
        $this->cacheDir = $cacheDir;
    }


    /**
     * Import all the new feed items.
     */
    public function importAll()
    {
        $feeds = $this->feedManager->findAll();

        foreach ($feeds as $feed) {
            $this->importFeed($feed);
        }
    }

    /**
     * Import one feed.
     *
     * @param \App\Entity\Feed $feed The feed
     *
     * @return int The count of saved items
     */
    public function importFeed(Feed $feed)
    {
        $itemCount = 0;
        $feedReader = new SimplePie();
        $feedReader->set_cache_location($this->cacheDir);
        $feedReader->set_feed_url($feed->getUrl());
        $feedReader->set_stupidly_fast(true);
        $feedReader->init();

        $feed->setTitle($feedReader->get_title());
        $feed->setDescription($feedReader->get_description());

        $items = $feedReader->get_items();

        if (null !== $items) {
            foreach ($items as $item) {
                if ($this->importFeedItem($item, $feed)) {
                    $itemCount++;
                }
            }

            $feed->setLastImport(new DateTime());
        }

        $this->feedManager->save($feed);
        return $itemCount;
    }

    /**
     * Import the item and save it if not already saved.
     *
     * @param \SimplePie_Item  $item The item
     * @param \App\Entity\Feed $feed The feed
     *
     * @return bool If an item has been saved
     */
    private function importFeedItem(SimplePie_Item $item, Feed $feed)
    {
        $title = $item->get_title();
        $feedDate = $item->get_date(DateTime::ISO8601);
        $date = DateTime::createFromFormat(DateTime::ISO8601, $feedDate);

        if (null !== $title && null !== $date && !$feed->isDateBeforeLastPast($date)) {
            $description = new Utf8($item->get_description());
            $description->encode();

            $enclosure = $item->get_enclosure();
            $feedItem = $this->feedItemManager->create([
                'title' => $title,
                'description' => $description->getValue(),
                'url' => $item->get_link(),
                'image' => (null !== $enclosure ? $enclosure->get_thumbnail() : null),
                'date' => $date
            ]);
            $feed->addItem($feedItem);
            return true;
        }

        return false;
    }
}
