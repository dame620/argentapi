<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Transaction;
use App\Operation\Algofrai;
use App\Repository\FraiRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\TransactionController;
use App\Repository\AffectationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransactionController extends AbstractController
{



  private $encoder;
  private $frairecup;
  
  public function __construct (UserPasswordEncoderInterface $encoder )
  {
      //, Algofrai $frairecup
      $this->encoder = $encoder;
     // $this->frairecup =$frairecup;
  
  }
    
    private $tokenstorage;
    private $entityManager;
    private $repoaffect;

    public function __invoke(Transaction $data,AffectationRepository $repoaffect,FraiRepository $fees,TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->repoaffect=$repoaffect;

        //recuperation du user connecté
       $userconnecte = $this->tokenStorage->getToken()->getUser();
       //affectation du user envoi au user connecté
       
      // dd($data->getUserenvoi());
//recuperation du compte du user connecte

      $comptuserconnecte=$userconnecte->getAffectations()[0]->getCompte();

      //dd($comptuserconnecte);
       //recuperation du compte
       //$compt=$data->getCompteenvoi();
       //dd($compt);
  //////a revoir     /$a=$this->repoaffect->findAll();
       //dd($a);

       //recuperation id compte pour code
       $idcompt = $comptuserconnecte->getId();
      // dd($idcompt);
       $numrand=rand(1000002,20000526);
       //format code
       $formatcod = $idcompt.$numrand;

//reglage transaction impossible si  periode depassé 
//date du jour
$datejour = new \DateTime();

//dd($datejour);
//recuperation date fin affectation 
$datefinaffectaion=$userconnecte->getAffectations()[0]->getDatefin();
//recuperation date debut affectation 
$datedebutaffectaion=$userconnecte->getAffectations()[0]->getDatedebut();
//dd($datedebutaffectaion);
//$datejour<$datedebutaffectaion
if($datejour<$datedebutaffectaion || $datejour>$datefinaffectaion){
  throw new Exception("attention vous n etes pas dans la periode d'affectation de votre compte");
}

       //reuperation des frais a refaire 
       /*
       $montantenvoiplusfrais=$data->getMontanttransaction();

      $a = $this->frairecup->getfrai($montantenvoiplusfrais);
      dd($a);
      */
        //recuperation du montant du compte avant envoi
        $soldecomptinitial=$comptuserconnecte->getSoldecompte();
        //dd($soldecomptinitial);
        
        //dd($soldecomptinitial);
 //recuperation des frais pour le retrancher  au montant total
      
       
        //recuperation du montant à envoyer 
        //dd($montantenvoi);
        //recuperation du montant total avec frais
        $montantenvoiplusfrais=$data->getMontanttransaction();

        if($montantenvoiplusfrais>2035650){
          $frai = 0.02*$montantenvoiplusfrais;
        }
        else{
          //recuperation e la colonne du frai
        $colfrai=$fees->findOneBymontant($montantenvoiplusfrais);
        //dd($colfrai);
        //recuperation de la valeur du frai
        $frai=$colfrai->getValeurfrai();
        }
        
        $pareta=$frai*0.4;
        $parenvoyeur = $frai*0.1;
        $parretrai=$frai*0.2;
        $parsyst=$frai*0.3;
        //dd($frai);
        //montant nete a envoyer
        $montantenvoi= $montantenvoiplusfrais-$frai;
        //controle du montant a envoyer qui doit etre inferieur au solde de votre compte
      //  dd($soldecomptinitial);
        if($montantenvoi > $soldecomptinitial){
          throw new Exception("le solde de votre compte est inferieur au montant de la transaction");
        }
 
       //dd($montantenvoi);
       //recuperation de cni du destinataire pour verifier qu'il s'agit d'un envoi
       $cnidesti = $data->getCnidestanataire();

       if($cnidesti==null){
           
        $data->setCode($formatcod);
        //set du userenvoi au user connecté
        $data->setUserenvoi($userconnecte);
        $data->setCompteenvoi($comptuserconnecte);
       // dd( $data->getCompteenvoi());

        $data->setFrais($frai);
        $data->setPartenvoyeur($parenvoyeur );
        $data->setPartretrait($parretrai);
        $data->setPartsysteme($parsyst);
        $data->setPartetat($pareta);
        $data->setStatu(false);
         //recuperation dans le compte du montant a envoyer
         $comptuserconnecte->setSoldecompte($soldecomptinitial- $montantenvoi);
       // dd( $comptuserconnecte->getSoldecompte());
      
       }

       else{
         //renseignement de l'id du user qui fait le retrait
        $data-> setUserretrait($userconnecte);
        //renseignement de l'id du compte retrait
        $data->setCompteretrait($comptuserconnecte);
           //recuperation du solde du compte du user qui fait le retrait
       // $soldecomptinitial=$comptuserconnecte->getSoldecompte();
        $comptuserconnecte->setSoldecompte($soldecomptinitial+$montantenvoi);
        $data->setStatu(true);
        

       }

      // else{ }
        //generation du code
        
        //fin generation du code
        //dd($data->getCode());
      
      // $soldeactuel=$compt->getSoldecompte();
     //  dd($soldeactuel);




       return $data;
    }
}
