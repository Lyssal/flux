<?php
namespace App\Controller;

use App\Entity\FeedItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for feed items.
 *
 * @Route("/FeedItem")
 */
class FeedItemController extends Controller
{
    /**
     * View a feed item.
     *
     * @Route("/{feedItem}/Read/{read}", name="flux_feeditem_read")
     *
     * @return Response
     */
    public function read(FeedItem $feedItem, $read)
    {
        $feedItem->setRead($read);
        $this->container->get('app.manager.feed_item')->save($feedItem);

        return $this->render('feed_item/read.html.twig', [
            'item' => $feedItem
        ]);
    }

    /**
     * Relove a feed item.
     *
     * @Route("/{feedItem}/Remove", name="flux_feeditem_remove")
     *
     * @return Response
     */
    public function remove(FeedItem $feedItem)
    {
        $this->container->get('app.manager.feed_item')->delete($feedItem);

        return new Response('');
    }
}
