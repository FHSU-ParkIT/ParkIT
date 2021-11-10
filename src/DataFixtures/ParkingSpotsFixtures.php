<?php

namespace App\DataFixtures;

use App\Entity\ParkingSpot;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


/**
 */
class ParkingSpotsFixtures extends Fixture
{
	public function __construct()
	{
	}

    public function load(ObjectManager $manager)
    {

        $lotName = 'A';

        // create 20 user accounts
        for ($i = 1; $i < 11; $i++) {

            $parkingSpot = new ParkingSpot();
            $parkingSpot->setLotName($lotName);
            $parkingSpot->setSpotNumber($i);
						// Push the user to DB
            $manager->persist($parkingSpot);
        }

        $manager->flush();
    }
}