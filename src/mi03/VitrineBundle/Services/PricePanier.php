<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 06/12/18
 * Time: 22:39
 */

namespace mi03\VitrineBundle\Services;


class PricePanier
{
    private $entityManager;
    private $panier;

    public function __construct(\Doctrine\ORM\EntityManager $em){
        $this->entityManager = $em;
    }

    /**@var EntityManager $this->doctrine*/
    public function getPricePanier($panier){
        $this->panier = $panier;
        $price =0;
        foreach ($this->panier->getContenu() as $id => $qte){
            $article = $this->entityManager->getRepository('mi03VitrineBundle:Article')->find($id);
            if($article!=null){
                $price += $article->getPrice() * $qte;
            }
        }

        return $price;
    }
}