<?php
namespace App\Controller;

use App\Entity\Category;
use App\Feed\CategoryFeedGetter;
use App\Feed\CategoryFeedItemGetter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for categories.
 *
 * @Route("/Category")
 */
class CategoryController extends Controller
{
    /**
     * View a category.
     *
     * @Route("/{category}/View/{read}", name="flux_category_view")
     *
     * @param \App\Entity\Category $category The category
     *
     * @return \Symfony\Component\HttpFoundation\Response The view
     */
    public function viewAction(Category $category, $read = null)
    {
        if (null !== $read) {
            $read = ('1' === $read);
        }
        $categoryFeedItemGetter = new CategoryFeedItemGetter();
        $items = $categoryFeedItemGetter->get($category, $read);

        return $this->render('category/view.html.twig', [
            'category' => $category,
            'items' => $items,
            'read' => $read,
            'itemCount' => $categoryFeedItemGetter->count($category),
            'readItemCount' => $categoryFeedItemGetter->count($category, true),
            'unreadItemCount' => $categoryFeedItemGetter->count($category, false)
        ]);
    }

    /**
     * Return the item count.
     *
     * @Route("/{category}/ItemCount", name="flux_category_itemcount")
     *
     * @param \App\Entity\Category $category The category
     *
     * @return \Symfony\Component\HttpFoundation\Response The response
     */
    public function itemCountAction(Category $category)
    {
        $categoryFeedItemGetter = new CategoryFeedItemGetter();

        return new Response($categoryFeedItemGetter->count($category));
    }

    /**
     * Return the read item count.
     *
     * @Route("/{category}/ReadItemCount", name="flux_category_readitemcount")
     *
     * @param \App\Entity\Category $category The category
     *
     * @return \Symfony\Component\HttpFoundation\Response The response
     */
    public function readItemCountAction(Category $category)
    {
        $categoryFeedItemGetter = new CategoryFeedItemGetter();

        return new Response($categoryFeedItemGetter->count($category, true));
    }

    /**
     * Return the unread item count.
     *
     * @Route("/{category}/UnreadItemCount", name="flux_category_unreaditemcount")
     *
     * @param \App\Entity\Category $category The category
     *
     * @return \Symfony\Component\HttpFoundation\Response The response
     */
    public function unreadItemCountAction(Category $category)
    {
        $categoryFeedItemGetter = new CategoryFeedItemGetter();

        return new Response($categoryFeedItemGetter->count($category, false));
    }
}
