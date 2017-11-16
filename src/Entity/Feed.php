<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * A RSS feed.
 *
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="url", columns={"url"})})
 */
class Feed
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
     * @var \App\Entity\Category The category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="feeds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var string The feed URL
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string The feed title
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string The feed description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime The last import date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastImport;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection<\App\Entity\FeedItem> The items
     *
     * @ORM\OneToMany(targetEntity="FeedItem", mappedBy="feed", cascade={"persist"})
     * @ORM\OrderBy({"date"="ASC"})
     */
    private $items;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set category
     *
     * @param \App\Entity\Category $category
     *
     * @return Feed
     */
    public function setCategory(\App\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \App\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Feed
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Feed
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
     * Set description
     *
     * @param string $description
     *
     * @return Feed
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set lastImport
     *
     * @param \DateTime $lastImport
     *
     * @return Feed
     */
    public function setLastImport($lastImport)
    {
        $this->lastImport = $lastImport;

        return $this;
    }

    /**
     * Get lastImport
     *
     * @return \DateTime
     */
    public function getLastImport()
    {
        return $this->lastImport;
    }

    /**
     * Add item
     *
     * @param \App\Entity\FeedItem $item
     *
     * @return Feed
     */
    public function addItem(\App\Entity\FeedItem $item)
    {
        $item->setFeed($this);
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \App\Entity\FeedItem $item
     */
    public function removeItem(\App\Entity\FeedItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
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
     * Return if the date is before the last import.
     *
     * @param \DateTime $date The date
     * @return bool If before
     */
    public function isDateBeforeLastPast(DateTime $date) : bool
    {
        return (null !== $this->lastImport && $date <= $this->lastImport);
    }
}
