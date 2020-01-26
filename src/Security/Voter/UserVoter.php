<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserVoter extends Voter
{

    private $security;
    private $tokenStorage;

    const VIEW = 'view';
    const EDIT = 'edit';
    const ADD = 'add';

    public function __construct(Security $security, TokenStorageInterface $tokenStorage)
    {
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
    }

    
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
       /* if(!in_array($attribute, [self::VIEW, self::EDIT, self::ADD])){
       return false;
}*/

return in_array($attribute, ['EDIT', 'VIEW', 'ADD'])
         && $subject instanceof \App\Entity\User;

   /* if(!$subject instanceof User ){
        return false;
    }

    return true;
    */

    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {


         // ROLE_SUPER_ADMIN can do anything! The power!
         if ($this->security->isGranted('ROLE_SUPADMIN')) {
            return true;
        }

        if ($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_ADMIN){
           if($subject->getRoles()[0]==self::ROLE_ADMIN || $subject->getRoles()[0]==self::ROLE_SUPADMIN){
               return false;
           }

        }

        if ($this->tokenStorage->getToken()->getRoles()[0]==self::ROLE_CAISSIER){
            if($subject->getRoles()[0]==self::ROLE_CAISSIER || $subject->getRoles()[0]==self::ROLE_ADMIN || $subject->getRoles()[0]==self::ROLE_SUPADMIN){
                return false;
            }
 
         }


        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

//check if the user is a actuel owner of the post
//verifier si le user qui est entrain d'effectuer sur un usrtr l'a crée
  /*      if (!$subject->getUser() === $user) {
            return false;
        }
      */ 
         // you know $subject is a Post object, thanks to supports
        /** @var User $post */

        $post = $subject;

       switch ($attribute) {

            case self::VIEW:
               return $this->canView($post, $user);

               if ($this->security->isGranted('ROLE_SUPADMIN')) {
                return true;
            }
            break;
                case self::ADD:
                return $this->canADD($post, $user);

                if ($this->security->isGranted('ROLE_SUPADMIN')) {
                    return true;
                }
            break;

            case self::EDIT:

                return $this->canEdit($post, $user);
                if ($this->security->isGranted('ROLE_SUPADMIN')) {
                    return true;
                }
            break;
        }
 throw new \LogicException('This code should not be reached!');
    }
/*
    private function canView(User $post, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($post, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return !$post->isPrivate();
    }

    private function canEdit(User $post, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $post->getOwner();
    }

*/
}
