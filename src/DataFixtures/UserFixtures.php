<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * This fixture class cna be used to load clients, managers and any sort of user. The load function is where that will happen.
 */
class UserFixtures extends Fixture
{
	private $userPasswordHasher;	
	public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
	{
		$this->userPasswordHasher = $userPasswordHasherInterface;
	}
    public function load(ObjectManager $manager)
    {

        // create 20 user accounts
        for ($i = 0; $i < 20; $i++) {

					
            $user = new User();
            $user->setEmail('user-'.$i.'@test.com');
						$user->setPhone('123-456-7890');
						$user->setPlainPassword('test123');
						
						// Set the password to the hashsed output of the plain password
						$user->setPassword(
							$this->userPasswordHasher->hashPassword(
											$user,
											$user->getPlainPassword()
									)
							);

						// Push the user to DB
            $manager->persist($user);
        }

				// Flush all changes to objects that have been queued up to now to the database.
        $manager->flush();
    }
}