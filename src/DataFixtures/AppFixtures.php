<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
    
        $user1 = new User("supadmin");
        $user1->setPassword($this->encoder->encodePassword($user1, "damndy"));
        $user1->setRoles(array("ROLE_SUPADMIN"));
        $user1->setIsActive(true);
        $user1->setUsername("dame620");
        $user1->setNomcomplet("damendiaye");
        $manager->persist($user1);

        $user2 = new User("admin");
        $user2->setPassword($this->encoder->encodePassword($user2, "abdou"));
        $user2->setRoles(array("ROLE_ADMIN"));
        $user2->setIsActive(true);
        $user2->setUsername("abdou123");
        $user2->setNomcomplet("abdoudiop");
        $manager->persist($user2);


        $user3 = new User("caissier");
        $user3->setPassword($this->encoder->encodePassword($user3, "fatou123"));
        $user3->setRoles(array("ROLE_CAISSIER"));
        $user3->setIsActive(true);
        $user3->setUsername("fatou");
        $user3->setNomcomplet("fatouba");
        $manager->persist($user3);
        
        $manager->flush();
    
    }
}
