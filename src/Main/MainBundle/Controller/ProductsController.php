<?php

namespace Main\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function listAction($category, $page)
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filters = $session->get('filters');
        if($request->getMethod()=="POST")
        {
            $sort_by = $request->get('sort_by');
            $direction = strtoupper($request->get('direction'));
            $session->set('filters',array('sort_by'=>$sort_by,'direction'=>$direction));
        }else
        {
            if(!$filters['sort_by'] || !$filters['direction'])
            {
                $session->set('filters',array('sort_by'=>'title','direction'=>'ASC'));
            }
            $sort_by = $filters['sort_by'];
            $direction = $filters['direction'];
        }
        $rows_per_page = $this->container->getParameter('main_main.prods.prods_limit');
        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                      ->getLatestProd($rows_per_page,$page,$sort_by,$direction, $category);
        /*$html = $this->render('MainMainBundle:Products:products_list.html.twig', array('prods'=>$prods,'page'=>$page));
        if($request->getMethod()=="POST")
        {
            $response = array("success" => true, 'innerHTML' => $html);
            return new Response(json_encode($response));
        }*/
        return $this->render('MainMainBundle:Products:products_list.html.twig', array('prods'=>$prods,'page'=>$page));
    }
    public function prodsAction($category, $page)
    {
        // $rows_per_page = $this->container->getParameter('main_main.prods.prods_limit');
        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds($category);
        $count = count($prods);
        return $this->render('MainMainBundle:Products:products.html.twig', array('count'=>$count, 'prods'=>$prods));
    }
}