<?php

namespace Main\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks()
 */
class Images
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Products", inversedBy="images")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $path;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $filename;

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
     * Set path
     *
     * @param string $path
     * @return Images
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set filename
     *
     * @param float $filename
     * @return Images
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return float 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set products
     *
     * @param \Main\MainBundle\Entity\Products $products
     * @return Images
     */
    public function setProducts(\Main\MainBundle\Entity\Products $products = null)
    {
        $this->products = $products;
    
        return $this;
    }

    /**
     * Get products
     *
     * @return \Main\MainBundle\Entity\Products 
     */
    public function getProducts()
    {
        return $this->products;
    }
}