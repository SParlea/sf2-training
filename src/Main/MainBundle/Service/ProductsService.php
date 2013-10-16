<?php
namespace Main\MainBundle\Service;

class ProductsService
{
	private $step_percent;
	// private $session;
	private $request;

	public function __construct($request, $step_percent)
    {
        $this->step_percent = $step_percent;
        // $this->session = $session;
        $this->request = $request;
    }

	public function getSteps($prods)
	{
		if(!empty($prods))
		{
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
	        $step_percent = $this->step_percent;
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
	                $step_min = number_format($step_min+$range_step+0.01,2);
	                $step_max = number_format($step_max+$range_step,2);
	                $i++;
	            }else
	            {
	                $filter = array('min'=>$step_min,'max'=>$step_max,'only_one'=>false);
	                array_push($steps, $filter);
	                $step_min = number_format($step_min+$range_step,2);
	                $step_max = number_format($step_max+$range_step,2);
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
        	return $steps;
        }else
        {
        	return '';
        }
	}
	public function getFiltersForList()
	{
		$request = $this->request;
        $session = $this->request->getSession();
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
            if($request->get('reset_filters')==true)
            {
                $session->remove('price_filter');
                $session->remove('category_filter');
                $session->remove('category_name');
            }
            if($request->get('category_id'))
            {
            	$session->set('category_filter',$request->get('category_id'));
            	$session->set('category_name',$request->get('category_name'));
            }
        }
        $filters = $session->get('filters');

        $sort_by = $filters['sort_by'];
        $direction = $filters['direction'];
        if($session->get('price_filter'))
        {
            $filter = $session->get('price_filter');
        }
		$filter['search'] = $request->get('search');
        $values = array('sort'=>$sort_by, 'direction'=> $direction, 'filter'=>$filter, 'category_filter'=>$session->get('category_filter'));

        return $values;
	}
	public function getFiltersForProducts($category)
	{
		$request = $this->request;
        $session = $this->request->getSession();
        $filter['search'] = $request->get('search');

        if($session->get('last_category')!=$category)
        {
            $session->remove('price_filter');
            $session->remove('category_filter');
            $session->remove('category_name');
        }
        if($session->get('price_filter'))
        {
            $the_filter = $session->get('price_filter');
            $is_filter = true;
            $prices = explode(",", $the_filter['price']);
            if($prices[1]!='NaN')
            {
                $range_value = $prices[0].'-'.$prices[1];
            }else
            {
                $range_value = $prices[0].' and above';
            }
        }else
        {
            $is_filter = false;
            $range_value = '';
        }
        if($session->get('category_filter'))
        {
        	$is_filter=true;
        }
        $session->set('last_category',$category);
        if(!$session->get('filters'))
        {
            $session->set('filters',array('sort_by'=>'title','direction'=>'ASC'));
        }

        $values = array('is_filter'=>$is_filter, 'range_value'=>$range_value, 'filter'=>$filter, 'category_name'=>$session->get('category_name'));

        return $values;
	}
	public function getSearchCategories($prods)
	{
		$categories = array();
		$category = array();
		$exists = array();
		foreach ($prods as $key => $product) {
			if(!in_array($product->getCategory()->getLabel(), $exists))
			{
				$category['id']=$product->getCategory()->getId();
				$category['label'] = $product->getCategory()->getLabel();
				array_push($categories, $category);
				array_push($exists, $category['label']);
			}
		}
		return $categories;
	}
	public function getRelatedProducts($products)
	{
		shuffle($products);
		return array_slice($products, 0, 4);
	}
}