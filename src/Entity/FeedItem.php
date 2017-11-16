<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * A feed item.
 *
 * @ORM\Entity()
 */
class FeedItem
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
     * @var \App\Entity\Feed The feed
     *
     * @ORM\ManyToOne(targetEntity="Feed", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $feed;

    /**
     * @var string The title
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string The description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string The feed URL
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string The image
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var \DateTime The date
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var bool If read
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=false, options={"default"=false})
     */
    private $read;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->read = false;
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
     * Set feed
     *
     * @param \App\Entity\Feed $feed
     *
     * @return FeedItem
     */
    public function setFeed(\App\Entity\Feed $feed)
    {
        $this->feed = $feed;

        return $this;
    }

    /**
     * Get feed
     *
     * @return \App\Entity\Feed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return FeedItem
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
     * @return FeedItem
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
     * Set url
     *
     * @param string $url
     *
     * @return FeedItem
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
     * Set image
     *
     * @param string $image
     *
     * @return FeedItem
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FeedItem
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set read
     *
     * @param boolean $read
     *
     * @return FeedItem
     */
    public function setRead($read)
    {
        $this->read = $read;

        return $this;
    }

    /**
     * Get read
     *
     * @return boolean
     */
    public function getRead()
    {
        return $this->read;
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
}
