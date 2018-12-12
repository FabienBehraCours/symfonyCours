<?php

namespace mi03\VitrineBundle\Entity;

/**
 * Commande
 */
class Commande
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $etat;

    /**
     * @var \mi03\VitrineBundle\Entity\Client
     */
    private $client;


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
     * Set etat.
     *
     * @param string $etat
     *
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat.
     *
     * @return bool
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set client.
     *
     * @param \mi03\VitrineBundle\Entity\Client|null $client
     *
     * @return Commande
     */
    public function setClient(\mi03\VitrineBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \mi03\VitrineBundle\Entity\Client|null
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * @var string
     */
    private $date;


    /**
     * Set date.
     *
     * @param string $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
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
     * @return Commande
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

    public function _toString()
    {
        return $this->getId();
    }
}
