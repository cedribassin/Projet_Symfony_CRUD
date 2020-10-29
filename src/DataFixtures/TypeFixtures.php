<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Aliment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $t1 = new Type();
        $t1->setLibelle("Fruits")
            ->setImage("fruits.jpg");
            $manager->persist($t1);

        $t2 = new Type();
        $t2->setLibelle("Legumes")
            ->setImage("legumes.jpg");
            $manager->persist($t2);
    
        //On récupère le repository de la class Aliment
        $alimentRepository = $manager->getRepository(Aliment::class);
        //findOneBy permet de récupérer un aliment en particulier à partir de 1 ou 
        // plusieurs propriétés (ici 1 seul qui est le nom de l'aliment)
        $a1 = $alimentRepository->findOneBy(["nom" => "Carotte"]); // => on récupère la carotte présente dans a1
        //On rajoute une modification pour apporter son Type
        $a1->setType($t2);
        $manager->persist($a1);

        $a2 = $alimentRepository->findOneBy(["nom" => "Patate"]);
        $a2->setType($t2);
        $manager->persist($a2);

        $a3 = $alimentRepository->findOneBy(["nom" => "Tomate"]);
        $a3->setType($t2);
        $manager->persist($a3);

        $a4 = $alimentRepository->findOneBy(["nom" => "Pomme"]);
        $a4->setType($t1);
        $manager->persist($a4);

        $manager->flush();
    }
}
