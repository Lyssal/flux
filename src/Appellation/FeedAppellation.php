<?php
namespace App\Appellation;

use App\Entity\Feed;
use Lyssal\EntityBundle\Appellation\AbstractDefaultAppellation;
use Symfony\Component\Routing\RouterInterface;

/**
 * The appellation for Feed.
 */
class FeedAppellation extends AbstractDefaultAppellation
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface The router
     */
    private $router;


    /**
     * FeedAppellation constructor.
     *
     * @param \Symfony\Component\Routing\RouterInterface $router The router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }


    /**
     * {@inheritDoc}
     */
    public function supports($object)
    {
        return ($object instanceof Feed);
    }

    /**
     * {@inheritDoc}
     */
    public function appellationHtml($feed)
    {
        return '<a href="'.$this->router->generate('flux_feed_view', ['feed' => $feed->getId()]).'">'.$this->appellation($feed).'</a>';
    }
}
