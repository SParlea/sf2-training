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
                    'category_name'=>$filter_values['category_name'],
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
                    ->getLatestProd($rows_per_page,$page,$filter_values['sort'],$filter_values['direction'], $filter_values['category_filter'], $filter_values['filter']);
        $nr_prod = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds($filter_values['category_filter'], $filter_values['filter']);
        $count = count($nr_prod);
        return $this->render('MainMainBundle:Products:products_list.html.twig', 
            array('prods'=>$prods,
                  'page'=>$page,
                  'count'=>$count,
                  'is_search'=>true));
    }
    public function productDetailAction($product_id)
    {
      $service = $this->container->get('main_main.products');
      $request = $this->getRequest();
      $em = $this->getDoctrine()
                   ->getManager();
      $product = $em->getRepository('MainMainBundle:Products')->find($product_id);
      $products = $em->getRepository('MainMainBundle:Products')->getNrofProds($product->getCategory()->getId(),null,$product_id);
      $related_products = $service->getRelatedProducts($products);
      if ($request->getMethod() == 'POST') {
        $this->get('session')->getFlashBag()->add('notice', $product->getTitle().' was added to your shopping cart.');
        return $this->redirect($this->generateUrl('main_main_product_detail',array('product_id'=>$product_id)));
      }

      return $this->render('MainMainBundle:Products:product_detail.html.twig', 
            array('product'=>$product,
                  'related_products'=>$related_products));
    }
    /**
     * @Route("/calendar", name="recruiting_calendar")
     */
    public function calendarAction()
    {
        $date_rfc3339 = date("Y-m-d\TH:i:s\Z");
        $dateTime = \DateTime::createFromFormat("Y-m-d\TH:i:s\Z", $date_rfc3339);
        $endTime=date('Y-m-d\TH:i:s', strtotime('+2 hour', $dateTime->getTimestamp()));
        $event = new Event();
        $event->setSummary($_POST['name']);
        $event->setLocation('Pitech Targu Mures');
        $start = new EventDateTime();
        $start->setDateTime($date_rfc3339);
        $event->setStart($start);
        $end = new EventDateTime();
        $end->setDateTime($endTime);
        $event->setEnd($end);

        $createdEvent = $service->events->insert('primary', $event);

        var_dump($createdEvent);die;
    }
}