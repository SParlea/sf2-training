<?php

namespace Main\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function listAction($category, $page)
    {
        $service = $this->container->get('main_main.products');
        $filter_values = $service->getFiltersForList();

        $rows_per_page = $this->container->getParameter('main_main.prods.prods_limit');

        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                    ->getLatestProd($rows_per_page,$page,$filter_values['sort'],$filter_values['direction'], $category, $filter_values['filter']);
        $nr_prod = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds($category, $filter_values['filter']);

        $count = count($nr_prod);
        return $this->render('MainMainBundle:Products:products_list.html.twig', 
            array('prods'=>$prods,
                  'page'=>$page,
                  'count'=>$count,
                  'is_search'=>false));
    }
    public function prodsAction($category, $page)
    {
        $service = $this->container->get('main_main.products');

        $filter_values = $service->getFiltersForProducts($category);

        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds($category);
        $steps = $service->getSteps($prods);
        $category_name = $em->getRepository('MainMainBundle:Categories')
                      ->getCategoryName($category);
        return $this->render('MainMainBundle:Products:products.html.twig',
                array('steps'=>$steps,
                    'prods'=>$prods,
                    'category_name'=>$category_name,
                    'is_filter'=>$filter_values['is_filter'],
                    'range_value'=>$filter_values['range_value'],
                    'is_search'=>false));
    }
    public function searchAction($page)
    {
        $service = $this->container->get('main_main.products');
        $filter_values = $service->getFiltersForProducts('search');

        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds(null, $filter_values['filter']);
        $count = count($prods);
        $steps = $service->getSteps($prods);
        $categories = $service->getSearchCategories($prods);
        return $this->render('MainMainBundle:Products:products.html.twig',
                array('steps'=>$steps,
                    'prods'=>$prods,
                    'is_filter'=>$filter_values['is_filter'],
                    'categories_filter'=>$categories,
                    'range_value'=>$filter_values['range_value'],
                    'is_search'=>true));
    }
    public function searchListAction($page)
    {
        $service = $this->container->get('main_main.products');
        $filter_values = $service->getFiltersForList();

        $rows_per_page = $this->container->getParameter('main_main.prods.prods_limit');

        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                    ->getLatestProd($rows_per_page,$page,$filter_values['sort'],$filter_values['direction'], null, $filter_values['filter']);
        $nr_prod = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds(null, $filter_values['filter']);
        $count = count($nr_prod);
        return $this->render('MainMainBundle:Products:products_list.html.twig', 
            array('prods'=>$prods,
                  'page'=>$page,
                  'count'=>$count,
                  'is_search'=>true));
    }
}