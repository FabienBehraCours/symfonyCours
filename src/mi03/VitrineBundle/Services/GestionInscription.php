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




class GestionInscription
{
    private $entityManager;
    private $client;


    public function __construct(\Doctrine\ORM\EntityManager $em){
        $this->entityManager = $em;
        $this->client = new Client();
    }

    public function checkConform($client){
        $this->client = $client;
        if($client== null){
            return false;
        }

        if($this->ifExist($client)){
            return false;
        }

        return true;
    }

    public function ifExist($client){
        $cl = $this->entityManager->getRepository('mi03VitrineBundle:Client')->findOneBy(array('mail'=>$client->getMail()));
        return ($cl != null);
    }

    public function register($client){
        $this->client=$client;
        $this->entityManager->persist($this->client);
        $this->entityManager->flush();
    }
}