<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create( 'fr_FR' );

        //FIXTURES FOR PRODUCT ENTITY
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setProductName( $faker->word );
            $product->setProductBrand( $faker->word );
            $product->setProductDescription( $faker->sentence( $nbWords = 6, $variableNbWords = true ) );
            $product->setProductPrice( $faker->numberBetween( $min = 150, $max = 1000 ) );
            $manager->persist( $product );
        }

        //FIXTURES FOR CLIENT ENTITY
        $client = new Client( 'janeDoe' );
        $client->setPassword( $this->encoder->encodePassword( $client, 'password' ) );
        $manager->persist( $client );

        //FIXTURES FOR USER ENTITY
        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setFirstName( $faker->firstName );
            $user->setLastName( $faker->lastName );
            $user->setPhone( $faker->phoneNumber );
            $user->setEmail( $faker->email );
            $user->setClient( $client );
            $manager->persist( $user );
        }

        $manager->flush();
    }
}
