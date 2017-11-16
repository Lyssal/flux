<?php
namespace App\Twig\Extension;

use Lyssal\Doctrine\Orm\Manager\EntityManager;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Extension Twig to have feed categories.
 */
class CategoryExtension extends Twig_Extension
{
    /**
     * @var \Lyssal\Doctrine\Orm\Manager\EntityManager The category manager
     */
    protected $categoryManager;


    /**
     * CategoryExtension constructor.
     *
     * @param \Lyssal\Doctrine\Orm\Manager\EntityManager $categoryManager The category manager
     */
    public function __construct(EntityManager $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }


    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
       return [
       	   new Twig_SimpleFunction('app_category_parents', array($this, 'getParentCategories'))
       ];
    }


    /**
     * Get the parent catégories.
     */
    public function getParentCategories()
    {
        return $this->categoryManager->findBy([
            'parent' => null
        ], [
            'position'
        ]);
    }
}
