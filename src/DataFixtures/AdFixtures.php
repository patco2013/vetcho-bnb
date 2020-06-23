<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Migrations\Version\Factory;
use Doctrine\Persistence\ObjectManager;


class AdFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');



        for($i = 1; $i < 30; $i++)
        {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 400);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('<p><p>', $faker->paragraphs(5)) . '<p>';

            $ad->setTitle($title)
               ->setCoverImage($coverImage)
               ->setIntroduction($introduction)
               ->setContent($content)
               ->setPrice(mt_rand(55, 300))
               ->setRooms(mt_rand(1, 10));
            
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
