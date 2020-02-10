<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



    class UserController extends AbstractController

    {
        private  $encoder;
  
        
        public function __construct(UserPasswordEncoderInterface $encoder)
        {
        
            $this->encoder = $encoder;
        }
        private $tokenstorage;
        private $entityManager;
    
        public function __invoke(User $data,TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, UserRepository $userrepo)
        {
            //dd($data->getRole()->getLibelle());
            $this->entityManager = $entityManager;
            $this->tokenStorage = $tokenStorage;
        
       $userconnecte = $this->tokenStorage->getToken()->getUser();
      //($userconnecte->getRole()->getLibelle());
            //recuperation du role
           // $rol = $data->getRole()->getLibelle();
             //dd($rol);
            if ($data->getPassword()) {
                $data->getPassword();
                $data->setPassword(
                    $this->encoder->encodePassword($data, $data->getPassword())
                );
              
                $data->eraseCredentials();
            }
    
            return $data;
        }
    }
