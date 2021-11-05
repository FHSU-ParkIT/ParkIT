<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
	private $userPasswordHasher;	
	public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
	{
		$this->userPasswordHasher = $userPasswordHasherInterface;
	}
    public function load(ObjectManager $manager)
    {

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail('user-'.$i.'@test.com');
						$user->setPhone('123-456-7890');
						$user->setPlainPassword('test123');

						$user->setPassword(
							$this->userPasswordHasher->hashPassword(
											$user,
											$user->getPlainPassword()
									)
							);


            $manager->persist($user);
        }

        $manager->flush();
    }
}