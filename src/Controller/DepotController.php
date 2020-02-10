<?php

namespace App\Controller;

use Exception;
use App\Entity\Depot;
use App\Repository\DepotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DepotController 
{
    
    private $tokenstorage;
    private $entityManager;


    public function __invoke(Depot $data, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, DepotRepository $compterepo)
    {

        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        //recuperation du user connecté
       $userconnecte = $this->tokenStorage->getToken()->getUser();

       //affectation du user connecte
       $data->setUser($userconnecte);

         //recuperation du compte
        $recupcompte = $data->getCompte();

        //recuperation de ancien montant
        $ancienmontantcompte= $recupcompte->getSoldecompte();

         //montant a deposer dans le compte
        $montantadeposer = $data->getMontantdepot();
        
        $recupcompte->setSoldecompte($ancienmontantcompte+$montantadeposer);
        //le montant du depot doit etre superieur a 25f cfa
      if( $montantadeposer < 25 ){
            throw new Exception("le montant a deposer doit etre superieue a 25 fcfa");
        }
        //affectation du montant du compte
        //$data->$recupcompte->setSoldecompte($ancienmontantcompte+$montantadeposer);

         return $data;

    }




}