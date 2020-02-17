<?php
namespace App\Controller;


use Exception;
use App\Entity\Affectation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AffectationController extends AbstractController
{



  private $encoder;
  
  

  public function __construct (UserPasswordEncoderInterface $encoder)
  {
      
      $this->encoder = $encoder;
    
  }
    
    private $tokenstorage;
    private $entityManager;


    public function __invoke(Affectation $data, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        
       $userconnecte = $this->tokenStorage->getToken()->getUser();
     //dd($userconnecte);
       $data->setUseraffecteur($userconnecte);
       //recuperation de l'id de l'entreprise (partenaire) du user connecte
       $idpartcon = $userconnecte->getPartenaire()->getId();
       //dd($idpartcon);
       //recuperation de l'entreprise(partenaire) du compte a affecte
       $idpartccompt = $data->getCompte()->getPartenaire()->getId();
       //dd($idpartccompt);
        //recuperation de l'id de l'entreprise (partenaire) du user a qui on affecte le compte
       $idpartrecepcompt=$data->getUser()->getPartenaire()->getId();
       //dd($idpartrecepcompt);
       if(($idpartcon!==$idpartccompt)|| ($idpartcon!==$idpartrecepcompt)||($idpartccompt!==$idpartrecepcompt)){
         
        throw new Exception("attention le compte que vous voulez affecte, vs et celui a qui vous voulez l affecte vs n'etes pas du meme entreprise");
       }



       return $data;

    }

        
  }