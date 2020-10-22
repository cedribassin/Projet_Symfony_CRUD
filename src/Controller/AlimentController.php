<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliments")
     */
    public function index(AlimentRepository $repository)
    {
        $aliments = $repository->findAll();
        return $this->render('aliment/aliments.html.twig', [
            "aliments"=>$aliments,
            "isCalorie"=>false,
            "isGlucide"=>false,
        ]);
    }

    /**
     * @Route("/aliments/calorie/{calorie}", name="alimentsParCalorie")
     */
    //On met calorie en paramètre pour récupérer les info liées calorie
    public function alimentsMoinsCaloriques(AlimentRepository $repository, $calorie)
    {
        //getAlimentsParProprietes() => fonction codée dans AlimentRepository
        $aliments = $repository->getAlimentsParProprietes('calorie', '<', $calorie);
        return $this->render('aliment/aliments.html.twig', [
            "aliments"=>$aliments,
            //on rajoute une condition qu'on met à true (idem à false dans index()),
            // qu'on pourra utiliser dans la vue
            "isCalorie"=>true,
            "isGlucide"=>false
        ]);
    }

    /**
     * @Route("/aliments/glucide/{glucide}", name="alimentsParGlucides")
     */
    //On met glucide en paramètre pour récupérer les info liées glucides
    public function alimentsMoinsGlucide(AlimentRepository $repository, $glucide)
    {
        //getAlimentsParProprietes() => fonction codée dans AlimentRepository
        $aliments = $repository->getAlimentsParProprietes('glucide', '<', $glucide);
        return $this->render('aliment/aliments.html.twig', [
            "aliments"=>$aliments,
            //on rajoute une condition qu'on met à true (idem à false dans index()),
            // qu'on pourra utiliser dans la vue
            "isCalorie"=>false,
            "isGlucide"=>true
        ]);
    }


}
