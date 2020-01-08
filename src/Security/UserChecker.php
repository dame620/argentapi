<?php

namespace App\Security;

use App\Entity\User;
use App\Security\User as AppUser;
use App\Exception\AccountDeletedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        $user1= new User;
        $isActive = $user1->getIsActive();
        if($isActive === false){
            
        }
        if (!$user instanceof AppUser) {
            return ;
        }
   
        // user is deleted, show a generic Account Not Found message.
        if ($user->isDeleted()) {
            throw new AccountDeletedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        $user1= new User;
        $isActive = $user1->getIsActive();
        if($isActive == 0){
            return;
        }

        if (!$user instanceof AppUser) {
            return ;
        }

        // user account is expired, the user may be notified
        if ($user->isExpired()) {
            throw new AccountExpiredException('...');
        }
    }
}