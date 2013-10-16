<?php

namespace Main\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Main\MainBundle\Entity\Repository\ProductsRepository")
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks()
 */
class Products
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    /**
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false, options={"default" = 0.00})
     */
    protected $price;
    /**
     * @ORM\ManyToOne(targetEntity="Authors", inversedBy="products")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected $author;

    /**
	 * @ORM\Column(type="string", length=255)
    */
    protected $isbn;

    /**
	 * @ORM\Column(name="appereance_year", type="integer", length=11)
    */
    protected $appereanceYear;

    /**
	 * @ORM\Column(type="text")
    */
    protected $description;
    /**
	 * @ORM\Column(name="short_desc", type="string", length=255)
    */
    protected $shortDesc;
    /**
	 * @ORM\Column(type="integer", length=11, nullable=false, options={"default" = 0})
    */
    protected $stock;
    /**
	 * @ORM\Column(type="boolean", nullable=false, options={"default" = 1})
    */
    protected $active;
    /**
     * @ORM\OneToMany(targetEntity="Images", mappedBy="products")
     */
    protected $images;

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
     * Set title
     *
     * @param string $title
     * @return Products
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     * @return Products
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    
        return $this;
    }

    /**
     * Get isbn
     *
     * @return string 
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set appereance_year
     *
     * @param integer $appereanceYear
     * @return Products
     */
    public function setAppereanceYear($appereanceYear)
    {
        $this->appereanceYear = $appereanceYear;
    
        return $this;
    }

    /**
     * Get appereance_year
     *
     * @return integer 
     */
    public function getAppereanceYear()
    {
        return $this->appereanceYear;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set short_desc
     *
     * @param string $shortDesc
     * @return Products
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;
    
        return $this;
    }

    /**
     * Get short_desc
     *
     * @return string 
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Products
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    
        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set active
     *
     * @param \tinyint $active
     * @return Products
     */
    public function setActive(\tinyint $active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return \tinyint 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set category
     *
     * @param \Main\MainBundle\Entity\Categories $category
     * @return Products
     */
    public function setCategory(\Main\MainBundle\Entity\Categories $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Main\MainBundle\Entity\Categories 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set author
     *
     * @param \Main\MainBundle\Entity\Authors $author
     * @return Products
     */
    public function setAuthor(\Main\MainBundle\Entity\Authors $author = null)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return \Main\MainBundle\Entity\Authors 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add images
     *
     * @param \Main\MainBundle\Entity\Images $images
     * @return Products
     */
    public function addImage(\Main\MainBundle\Entity\Images $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Main\MainBundle\Entity\Images $images
     */
    public function removeImage(\Main\MainBundle\Entity\Images $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}