<?php

namespace App\Security\Voter;

use Exception;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserVoter extends Voter
{
    /*
    const ROLE_SUPADMIN = 'ROLE_SUPADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_CAISSIER = 'ROLE_CAISSIER';
    */
    private $security;
    private $tokenStorage;
    private $decisionManager;
    

    public function __construct(Security $security, TokenStorageInterface $tokenStorage, AccessDecisionManagerInterface $decisionManager )
    {
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
        $this->decisionManager = $decisionManager;
    }

    
    protected function supports($attribute, $subject)
    {
   

return in_array($attribute, ['EDIT', 'VIEW', 'POST'])
         && $subject instanceof \App\Entity\User;

   
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {

        
     //dd($subject);
         $user = $token->getUser();
        
        // if the user is anonymous, do not grant access
        
        if (!$user instanceof UserInterface) {
            return false;
        }
        
       // $rol = $subject->getRole()->getLibelle();
      //  $subject->setRoles(array("ROLE_".$rol));

        //dd($user->getRole()->getLibelle());
       if($user->getRole()->getLibelle() == "SUPADMIN"){
        return true;
       }
      
       if($user->getRole()->getLibelle() == "CAISSIER"){
        throw new Exception("attention vous ne pouvez pas effectuer cette action en tant que caissier");
    }
   // dd($user->getRole()->getLibelle());
    //dd($user->getRole()->getLibelle());
   // $makhou = ($user->getRoles()[0]);
  // dd($user->getRoles()[0]);
  if(($user->getRole()->getLibelle()=== "ADMIN") &&(
    $subject->getRole()->getLibelle() == "SUPADMIN" || $subject->getRole()->getLibelle() == "ADMIN" 
 )){
    throw new Exception("attention vous ne pouvez pas effectuer cette action en tant que admin");
 }

 if(($user->getRole()->getLibelle()=== "PARTENAIRE") &&(
    $subject->getRole()->getLibelle() == "SUPADMIN" || $subject->getRole()->getLibelle() == "ADMIN" 
    || $subject->getRole()->getLibelle() == "CAISSIER" 
 )){
    throw new Exception("attention vous ne pouvez pas effectuer cette action en tant que partenaire");
 }

       switch ($attribute) {
        case 'POST':
            
        break;

            case 'VIEW':
          
            break;
                
            case 'EDIT':

             
            break;
                 }
 
               return true;
  }
}
//comment
/*        
        if (( $userconnecte->getRoles()[0]==self::ROLE_ADMIN ) && ($subject->getRoles()[0]==self::ROLE_ADMIN || $subject->getRoles()[0]==self::ROLE_SUPADMIN)){
               throw new Exception ("impossible d\'\effectuer cette operation");
           

        }
//throw new \Exception('impossible d\'effectuer cette action');
        elseif(($userconnecte->getRoles()[0]==self::ROLE_CAISSIER) && ($subject->getRoles()[0]==self::ROLE_CAISSIER || $subject->getRoles()[0]==self::ROLE_ADMIN || $subject->getRoles()[0]==self::ROLE_SUPADMIN)){
           
         throw new Exception ("impossible d\'\effectuer cette operation");
            
         }


              // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
       /* if(!in_array($attribute, [self::VIEW, self::EDIT, self::ADD])){
       return false;
}

if ($this->decisionManager->decide($token, array(self::ROLE_SUPADMIN))){
            return true;
        }

                

         // ROLE_SUPER_ADMIN can do anything! The power!
         
        //user qui s'est connecté
        $userconnecte = $this->tokenStorage->getToken()->getUser();


*/