<?php
namespace App\Controller;

use App\Entity\Category;
use App\Feed\CategoryFeedGetter;
use App\Feed\CategoryFeedItemGetter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for homepage.
 *
 * @Route()
 */
class IndexController extends Controller
{
    /**
     * The homepage.
     *
     * @Route("/")
     *
     * @return Response
     */
    public function viewAction()
    {
        return $this->render('index/view.html.twig', [
            'feedCount' => $this->container->get('app.manager.feed')->count(),
            'unreadFeedItemCount' => $this->container->get('app.manager.feed_item')->count(['read' => false])
        ]);
    }
}
