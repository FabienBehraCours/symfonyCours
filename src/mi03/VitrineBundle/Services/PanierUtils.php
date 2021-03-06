<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 05/12/18
 * Time: 15:27
 */

namespace mi03\VitrineBundle\Services;


use DateTime;
use Doctrine\ORM\EntityManager;
use mi03\VitrineBundle\Entity\Article;
use mi03\VitrineBundle\Entity\Commande;
use mi03\VitrineBundle\Entity\LigneCommande;
use mi03\VitrineBundle\Entity\Panier;
use Symfony\Component\Validator\Constraints\Date;

class PanierUtils
{
    private $entityManager;
    private $panier;

    public function __construct(\Doctrine\ORM\EntityManager $em){
        $this->entityManager = $em;
    }

    public function seeContentPanier($panier){
        $this->panier = $panier;
        $commande = new Commande();
        foreach ($this->panier->getContenu() as $id => $qte){
            $article = $this->entityManager->getRepository("mi03VitrineBundle:Article")->find($id);

            if($article != null && $article != ""){
                if($qte <1){$qte =1;}
                $ligneDeCommande = new LigneCommande();
                $ligneDeCommande->setCommande($commande);
                $ligneDeCommande->setArticle($article);
                $ligneDeCommande->setQuantite($qte);
                $ligneDeCommande->setPriceArticle($article->getPrice());

                $commande->addLigneCommande($ligneDeCommande);
                //valeurs de base pour test
                $commande->setClient($this->entityManager->getRepository("mi03VitrineBundle:Client")->find(1));
                $commande->setDate(new \DateTime());
                $commande->setEtat("EN_COURS");
            }
        }
        return $commande;
    }

    public function convertPanierToCommande($panier, $idClient){
        $this->panier = $panier;
        $commande = null;
        $client = $this->entityManager->getRepository('mi03VitrineBundle:Client')->find($idClient);
        if($client != null){
            $commande = new Commande();
            foreach ($this->panier->getContenu() as $id => $qte){
                $article = $this->entityManager->getRepository("mi03VitrineBundle:Article")->find($id);

                if($article != null && $article != ""){
                    if($qte <1){$qte =1;}
                    $ligneDeCommande = new LigneCommande();
                    $ligneDeCommande->setCommande($commande);
                    $ligneDeCommande->setArticle($article);
                    $ligneDeCommande->setQuantite($qte);
                    $ligneDeCommande->setPriceArticle($article->getPrice());

                    $commande->addLigneCommande($ligneDeCommande);
                    //valeurs de base pour test
                    $commande->setClient($client);
                    $commande->setDate(new \DateTime());
                    $commande->setEtat("EN_COURS");
                    $this->entityManager->persist($ligneDeCommande);
                }
            }

            $this->entityManager->persist($commande);
            $this->entityManager->flush();
        }

        return $commande;
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

    public function removeQuantityInStockArticle($commande){
        foreach ($commande->getLigneCommande() as $item){
            $item->getArticle()->removeQuantityInStock(intval($item->getQuantite(),10));
            dump($item->getArticle());
            $this->entityManager->persist($item->getArticle());
        }
        $this->entityManager->flush();
    }


}