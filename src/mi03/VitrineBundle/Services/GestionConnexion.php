<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 11/12/18
 * Time: 20:56
 */

namespace mi03\VitrineBundle\Services;
use Doctrine\ORM\EntityManager;
use mi03\VitrineBundle\Entity\Client;


class GestionConnexion
{

    private $entityManager;
    private $client;


    public function __construct(\Doctrine\ORM\EntityManager $em){
        $this->entityManager = $em;
        $this->client = new Client();
    }

    public function checkConnexion($client){
        $this->client = $client;
        if($client== null){
            return false;
        }

        if(!$this->ifExist($client)){
            return false;
        }

        $clientEnBase = $this->entityManager->getRepository('mi03VitrineBundle:Client')->findOneBy(array('mail'=>$client->getMail()));
        return $this->checkPassword($client,$clientEnBase);
    }

    public function checkPassword($client, $clientEnBase){
        return($client->getPassword()==$clientEnBase->getPassword());
    }

    public function ifExist($client){
        $cl = $this->entityManager->getRepository('mi03VitrineBundle:Client')->findOneBy(array('mail'=>$client->getMail()));
        return ($cl != null);
    }

    public function connect($client){
       return $this->entityManager->getRepository('mi03VitrineBundle:Client')->findOneBy(array('mail'=>$client->getMail()));
    }

}