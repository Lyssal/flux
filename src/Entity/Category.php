<?php
namespace App\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * A feed category.
 *
 * @ORM\Entity()
 */
class Category
{
    /**
     * @var int The ID
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string The title
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \App\Entity\Category The parent category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @var integer The position
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $position;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection<\App\Entity\Category> The category children
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $children;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection<\App\Entity\Feed> The feeds
     *
     * @ORM\OneToMany(targetEntity="Feed", mappedBy="category")
     */
    private $feeds;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feeds = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set parent
     *
     * @param \App\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\App\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \App\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add child
     *
     * @param \App\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\App\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \App\Entity\Category $child
     */
    public function removeChild(\App\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add feed
     *
     * @param \App\Entity\Feed $feed
     *
     * @return Category
     */
    public function addFeed(\App\Entity\Feed $feed)
    {
        $this->feeds[] = $feed;

        return $this;
    }

    /**
     * Remove feed
     *
     * @param \App\Entity\Feed $feed
     */
    public function removeFeed(\App\Entity\Feed $feed)
    {
        $this->feeds->removeElement($feed);
    }

    /**
     * Get feeds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeeds()
    {
        return $this->feeds;
    }


    /**
     * Get the title.
     *
     * @return string The title
     */
    public function __toString()
    {
        return (string) $this->title;
    }


    /**
     * Get the feed items.
     *
     * @param bool $read The item read
     *
     * @return \App\Entity\FeedItem[] The items
     */
    public function getFeedItems($read = null)
    {
        $items = [];
        $readCriteria = Criteria::create()
            ->where(Criteria::expr()->eq('read', $read));

        foreach ($this->feeds as $feed) {
            $itemCollection = $feed->getItems();
            if (null !== $read) {
                $itemCollection = $itemCollection->matching($readCriteria);
            }

            $items = array_merge($items, $itemCollection->toArray());
        }

        return $items;
    }

    /**
     * Get the item count.
     *
     * @param bool|null $read The read
     *
     * @return int The count
     */
    public function getFeedItemCount($read = null)
    {
        return count($this->getFeedItems($read));
    }
}
