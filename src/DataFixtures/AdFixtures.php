<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Migrations\Version\Factory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $genres = ['male', 'female'];

        //Manage users / Gérons les utilisateurs
        $users = [];

        for($i = 1; $i <= 10; $i++)
        {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $password = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription( '<p>' . join('<p><p>', $faker->paragraphs(3)) . '<p>')
                 ->setPassword($password)
                 ->setPicture($picture);

            $manager->persist($user);

            $users[] = $user;

        }

        //Manage ads / Gérons les annonces
        for($i = 1; $i < 30; $i++)
        {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 400);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('<p><p>', $faker->paragraphs(5)) . '<p>';

            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
               ->setCoverImage($coverImage)
               ->setIntroduction($introduction)
               ->setContent($content)
               ->setPrice(mt_rand(55, 300))
               ->setRooms(mt_rand(1, 10))
               ->setAuthor($user);
            
            for($j = 1; $j <= (mt_rand(2, 6)); $j++)
            {
                $image = new Image();

                $url = $faker->imageUrl();
                $caption = $faker->sentence();

                $image->setUrl($url)
                      ->setCaption($caption)
                      ->setAd($ad);
                
                $manager->persist($image);
            }
    
            $manager->persist($ad);
           
            $manager->flush();
        }
      
    }
}
