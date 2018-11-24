<?php

namespace mi03\VitrineBundle\Entity;

/**
 * LigneCommande
 */
class LigneCommande
{
    /**
     * @var int
     */
    private $quantite;

    /**
     * @var string
     */
    private $priceArticle;

    /**
     * @var \mi03\VitrineBundle\Entity\Article
     */
    private $article;

    /**
     * @var \mi03\VitrineBundle\Entity\Commande
     */
    private $commande;


    /**
     * Set quantite.
     *
     * @param int $quantite
     *
     * @return LigneCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite.
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set priceArticle.
     *
     * @param string $priceArticle
     *
     * @return LigneCommande
     */
    public function setPriceArticle($priceArticle)
    {
        $this->priceArticle = $priceArticle;

        return $this;
    }

    /**
     * Get priceArticle.
     *
     * @return string
     */
    public function getPriceArticle()
    {
        return $this->priceArticle;
    }

    /**
     * Set article.
     *
     * @param \mi03\VitrineBundle\Entity\Article $article
     *
     * @return LigneCommande
     */
    public function setArticle(\mi03\VitrineBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article.
     *
     * @return \mi03\VitrineBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set commande.
     *
     * @param \mi03\VitrineBundle\Entity\Commande $commande
     *
     * @return LigneCommande
     */
    public function setCommande(\mi03\VitrineBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande.
     *
     * @return \mi03\VitrineBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
