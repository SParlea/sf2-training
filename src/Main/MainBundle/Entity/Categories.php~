<?php

namespace Main\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Main\MainBundle\Entity\Repository\CategoriesRepository")
 * @ORM\Table(name="categories")
 * @ORM\HasLifecycleCallbacks()
 */
class Categories
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
	 * @ORM\Column(type="string")
    */
    protected $label;
    /**
     * @ORM\OneToMany(targetEntity="Products", mappedBy="category")
     */
    protected $products;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Categories
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add products
     *
     * @param \Main\MainBundle\Entity\Products $products
     * @return Categories
     */
    public function addProduct(\Main\MainBundle\Entity\Products $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \Main\MainBundle\Entity\Products $products
     */
    public function removeProduct(\Main\MainBundle\Entity\Products $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}