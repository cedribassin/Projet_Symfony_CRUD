<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliment", name="admin_admin_aliments")
     */
    public function index(AlimentRepository $repository)
    {
        $aliments = $repository->findAll();

        return $this->render('admin/admin_aliment/adminAliments.html.twig', [
            "aliments"=>$aliments
        ]);
    }

    /**
     * @Route("/admin/creation", name="admin_admin_creation")
     * @Route("/admin/{id}", name="admin_admin_modification", methods="GET|POST")
     */
    //Fonction qui permet de créer, ou récupérer un aliment pour le modifier (en rajoutant methods="GET|POST" 
    // dans les routes, on va pouvoir distinguer son url de celle présente dans la fonction suppressionAliment())
    //Pour le cas de la création on rajoute null car l'aliment n'est pas encore crée
    public function ajoutEtModification(Aliment $aliment = null, Request $request, EntityManagerInterface $entityManager)
    {
        //S'il n'y a pas d'aliments (car il n'existe pas encore), on test et on génère un nouvel
        //aliment:
        if (!$aliment){
            $aliment = new Aliment();
        }
        //On indique que l'on crée un formulaire qui porte sur la classe AlimentType et l'aliment selectionné
        $form = $this->createForm(AlimentType::class, $aliment);
        //On récupère la requete que l'on peut traiter au niveau du formulaire:
        $form->handleRequest($request);
        //On vérifie si notre formulaire à été soumis et s'il est valide:
        if($form->isSubmitted() && $form->isValid()){
            //On test s'il s'agit d'un ajout ou d'une modification pour l'utiliser dans addFlash():
            $modif = $aliment->getId() !== null; 
            //si c'est le cas, on valide les info en utilisant la classe EntityManagerInterface et on 
            // envoie en BDD avec la fonction flush:
            $entityManager->persist($aliment);
            $entityManager->flush();
            //Pour envoyer une alerte:
            $this->addFlash("success", $modif ? "La modification a été effectuée" : "L'ajout a été effectuée");
            //Lorsque les actions sont réalisées on redirige vers la page souhaitée:
            return $this->redirectToRoute("admin_admin_aliments");
        }
        return $this->render('admin/admin_aliment/modifEtAjoutAliment.html.twig', [
            "aliment"=>$aliment,
            // createView() => Ici on renvoie juste la partie affichage du formulaire
            "form"=>$form->createView(),
            //Pour modifier le titre à l'affichage, on peut tester si getId() !== null et l'utiliser
            // dans la vue modifEtAjoutAliment.html.twig
            "isModification" => $aliment->getId() !== null 
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin_admin_suppression", methods="delete")
     */
    //Fonction permettant de supprimer un aliment (en rajoutant methods="delete" dans les routes, on va pouvoir distinguer
    // son url de celle présente dans la fonction ajoutEtModification())
    public function suppressionAliment(Aliment $aliment, Request $request, EntityManagerInterface $entityManager)
    {
        //On vérifie que le token de la requete est valide en vérifiant si les info sont identiques à celles pour générer 
        // le token dans la vue adminAliments.html.twig.php, et si c'est la cas alors on peut réaliser les actions en BDD
        if ($this->isCsrfTokenValid("SUP". $aliment->getId(), $request->get('_token'))){
        //On prépare la requête de suppression avec remove() et on envoie en BDD avec flush()
        $entityManager->remove($aliment);
        $entityManager->flush();
        $this->addFlash("success","La suppression a été effectuée");
        return $this->redirectToRoute("admin_admin_aliments");
        }
    }
}
