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
        $filter = null;
        
        if($request->getMethod()=="POST")
        {
            if($request->get('sort_by') || $request->get('direction'))
            {
                $sort_by = $request->get('sort_by');
                $direction = strtoupper($request->get('direction'));
                $session->set('filters',array('sort_by'=>$sort_by,'direction'=>$direction));
            }
            if($request->get('min_value') || $request->get('max_value'))
            {
                $price_min = $request->get('min_value');
                $price_max = $request->get('max_value');
                $filter['price'] = $price_min.','.$price_max;
                $session->set('price_filter',$filter);
            }
        }
        $filters = $session->get('filters');

        $sort_by = $filters['sort_by'];
        $direction = $filters['direction'];
        if($session->get('price_filter'))
        {
            $filter = $session->get('price_filter');
        }

        $rows_per_page = $this->container->getParameter('main_main.prods.prods_limit');
        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                    ->getLatestProd($rows_per_page,$page,$sort_by,$direction, $category, $filter);
        $nr_prod = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds($category, $filter);
        $count = count($nr_prod);
        return $this->render('MainMainBundle:Products:products_list.html.twig', 
            array('prods'=>$prods,
                  'page'=>$page,
                  'count'=>$count));
    }
    public function prodsAction($category, $page)
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        if($session->get('last_category')!=$category)
        {
            $session->remove('price_filter');
        }
        $session->set('last_category',$category);
        // $filter = null;
        if(!$session->get('filters'))
        {
            $session->set('filters',array('sort_by'=>'title','direction'=>'ASC'));
        }
        $em = $this->getDoctrine()
                   ->getManager();
        $prods = $em->getRepository('MainMainBundle:Products')
                      ->getNrofProds($category);

        $count = count($prods);
        $max_value = 0;
        $min_value = $prods[0]->getPrice();
        foreach ($prods as $key => $value) {
            if($max_value<$value->getPrice())
            {
                $max_value = $value->getPrice();
            }
            if ($min_value>$value->getPrice())
            {
                $min_value = $value->getPrice();
            }
        }
        $step_percent = $this->container->getParameter('main_main.filter.percent_step');
        $steps = array();
        $filter = array();
        $step_min = 0.00;
        $step_max = number_format($step_percent/100*$max_value,2);
        $range_step = $step_max;
        $i=1;
        while($step_max<$max_value)
        {
            if($i==1)
            {
                $filter = array('min'=>$step_min,'max'=>$step_max,'only_one'=>false);
                array_push($steps, $filter);
                $step_min = $step_min+$range_step+0.01;
                $step_max = $step_max+$range_step;
                $i++;
            }else
            {
                $filter = array('min'=>$step_min,'max'=>$step_max,'only_one'=>false);
                array_push($steps, $filter);
                $step_min = $step_min+$range_step;
                $step_max = $step_max+$range_step;
                $i++;
            }
        }
        if($i!=1)
        {
            $filter = array('min'=>$step_min,'max'=>'','only_one'=>false);
            array_push($steps,$filter);
        }else
        {
            $filter = array('min'=>$step_min,'max'=>$step_max,'only_one'=>true);
            array_push($steps, $filter);
        }
        return $this->render('MainMainBundle:Products:products.html.twig',
                array('steps'=>$steps,
                    'prods'=>$prods));
    }
}