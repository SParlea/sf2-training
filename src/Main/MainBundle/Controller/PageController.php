<?php

namespace Main\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class PageController extends Controller
{
    public function indexAction()
    {
    	/*$session = new Session();
		$session->start();

		// set and get session attributes
		$session->set('name', 'Drak');
		$session->set('name2', 'Drak222');*/
    	$em = $this->getDoctrine()
    			   ->getManager();
    	$prods = $em->getRepository('MainMainBundle:Products')
    				  ->getLatestProd(6);
        return $this->render('MainMainBundle:Page:index.html.twig', array('prods'=>$prods));
    }
    public function categoriesAction()
    {
    	$em = $this->getDoctrine()
    			   ->getManager();
    	$categs = $em->getRepository('MainMainBundle:Categories')
    				  ->getCategories();
    	return $this->render('MainMainBundle:Page:categories.html.twig', array('categs'=>$categs));
    }
}
