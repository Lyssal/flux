<?php
namespace App\Controller;

use App\Entity\Feed;
use App\Feed\FeedImport;
use SimplePie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for feeds.
 *
 * @Route("/Feed")
 */
class FeedController extends Controller
{
    /**
     * View a feed.
     *
     * @Route("/{feed}/View", name="flux_feed_view")
     *
     * @return Response
     */
    public function viewAction(Feed $feed)
    {
        return $this->render('feed/view.html.twig', [
            'feed' => $feed
        ]);
    }

    /**
     * Just view a feed file.
     *
     * @Route("/{feed}/File", name="flux_feed_viewfile")
     *
     * @return Response
     */
    public function viewFileAction(Feed $feed)
    {
        $feedFile = new SimplePie();
        $feedFile->set_cache_location($this->container->getParameter('kernel.cache_dir'));
        $feedFile->set_feed_url($feed->getUrl());
        $feedFile->enable_order_by_date();
        $feedFile->init();

        return $this->render('feed/view_file.html.twig', [
            'feed' => $feedFile
        ]);
    }

    /**
     * Import all the new items in feeds.
     *
     * @Route("/ImportAll")
     *
     * @return Response
     */
    public function importAllAction()
    {
        $this->container->get(FeedImport::class)->importAll();

        return new Response('OK');
    }
}
