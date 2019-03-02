<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create( 'fr_FR' );

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setProductName( $faker->word );
            $product->setProductBrand( $faker->word );
            $product->setProductDescription( $faker->sentence( $nbWords = 6, $variableNbWords = true ) );
            $product->setProductPrice( $faker->numberBetween( $min = 150, $max = 1000 ) );
            $manager->persist( $product );
        }

        for($i = 0; $i < 15; $i++){
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setEmail($faker->email);
            $manager->persist( $user );
        }

        $client = new Client('janeDoe');
        $client->setPassword('password');
        $manager->persist( $client );

        $client = new Client('joneDoe');
        $client->setPassword('password');
        $manager->persist( $client );


        $manager->flush();
    }
}
