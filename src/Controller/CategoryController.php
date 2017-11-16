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
     * @return Response
     */
    public function view(Category $category, $read = null)
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
}
