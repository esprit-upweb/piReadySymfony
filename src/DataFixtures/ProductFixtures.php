<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Faker\Factory;
class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
    $faker = Factory::create('fr_FR');
    for ($i = 0; $i < 150; $i++) {
        $product = new Product();
        $name = $faker->unique()->words(2, true); // Génère deux mots aléatoires
        $product->setName($name);
        $product->setSlug((new Slugify())->slugify($name));
        $product->setPrice(mt_rand(10, 100));
        $product->setDescription('lorem'.$i);
        $product->setQuantity(mt_rand(10, 100));
        $product->setCreatedAt( new DateTimeImmutable());
        $product->setUpdatedAt(new DateTimeImmutable());   
        $manager->persist($product);
    }
    $manager->flush();
}
}
