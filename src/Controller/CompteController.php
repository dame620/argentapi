<?php

namespace App\Controller;

use Exception;
use App\Entity\Compte;
use Doctrine\ORM\EntityManager;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CompteController extends AbstractController
{



  private $encoder;
  
  public function __construct (UserPasswordEncoderInterface $encoder)
  {
      
      $this->encoder = $encoder;
    
  }
    
    private $tokenstorage;
    private $entityManager;


    public function __invoke(Compte $data, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, CompteRepository $compterepo)
    {

        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        
       $userconnecte = $this->tokenStorage->getToken()->getUser();
       $data->setUser($userconnecte);

         /*      
     //autre methode wane
    //recuperation class depot
     $depotclass = $data->getDepots()[0];
    //recuperation du montant du premiere depot sur le compte
    $firstsoldecompte = $data->getSoldecompte();
    //affectation du montant depot
    $depotclass->setMontantdepot($firstsoldecompte);
      */

       $montdepo = $data->getDepots()[0]->getMontantdepot();
       $data->setSoldecompte( $montdepo);
      // $firstsoldecompte = $data->getSoldecompte();
      $firstsoldecompte = $data->getSoldecompte();

        if($firstsoldecompte < 500000 ){
             throw new Exception("le solde doit etre superieur a 500000");
        }
 
        

//recuperation du userpartenaire pour qui ont crée le compte

$userpartenaire=$data->getPartenaire()->getUsers()[0];
//recuperation password userpartenaire
$passwordusers = $userpartenaire->getPassword();
//encodage du mot de passe
$userpartenaire->setPassword($this->encoder->encodePassword($userpartenaire, $passwordusers));




         return $data;
    }
}
