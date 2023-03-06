<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ProductFactory;
use App\Factory\OrderFactory;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        UserFactory::createMany(10);
        ProductFactory::createMany(40);
        OrderFactory::createMany(40, function () {
            return [
                'customer' => UserFactory::random(),
            ];
        });
    }
}
