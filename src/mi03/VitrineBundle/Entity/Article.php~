<?php

namespace mi03\VitrineBundle\Entity;

/**
 * Article
 */
class Article
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $price;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * @var \mi03\VitrineBundle\Entity\Category
     */
    private $category;


    /**
     * Set category.
     *
     * @param \mi03\VitrineBundle\Entity\Category|null $category
     *
     * @return Article
     */
    public function setCategory(\mi03\VitrineBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return \mi03\VitrineBundle\Entity\Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ligneCommande;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ligneCommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ligneCommande.
     *
     * @param \mi03\VitrineBundle\Entity\LigneCommande $ligneCommande
     *
     * @return Article
     */
    public function addLigneCommande(\mi03\VitrineBundle\Entity\LigneCommande $ligneCommande)
    {
        $this->ligneCommande[] = $ligneCommande;

        return $this;
    }

    /**
     * Remove ligneCommande.
     *
     * @param \mi03\VitrineBundle\Entity\LigneCommande $ligneCommande
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLigneCommande(\mi03\VitrineBundle\Entity\LigneCommande $ligneCommande)
    {
        return $this->ligneCommande->removeElement($ligneCommande);
    }

    /**
     * Get ligneCommande.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLigneCommande()
    {
        return $this->ligneCommande;
    }
}
