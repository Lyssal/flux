<?php
namespace App\Appellation;

use App\Entity\Category;
use App\Entity\Feed;
use Lyssal\EntityBundle\Appellation\AbstractDefaultAppellation;
use Symfony\Component\Routing\RouterInterface;

/**
 * The appellation for Category.
 */
class CategoryAppellation extends AbstractDefaultAppellation
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
        return ($object instanceof Category);
    }

    /**
     * {@inheritDoc}
     */
    public function appellationHtml($category)
    {
        return '<a href="'.$this->router->generate('flux_category_view', ['category' => $category->getId(), 'read' => '0']).'" data-ajax="true">'.$this->appellation($category).'</a>';
    }
}
