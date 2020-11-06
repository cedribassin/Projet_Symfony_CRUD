<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypesController extends AbstractController
{
    /**
     * @Route("/admin/type", name="adminTypes")
     */
    public function index(TypeRepository $repo)
    {
        $types = $repo->findAll();
        return $this->render('admin/adminTypes/adminTypes.html.twig', [
            "types" => $types
        ]);
    }

     /**
     * @Route("/admin/types/create", name="admin_createType")
     * @Route("/admin/types/{id}", name="modifType", methods="GET|POST")
     */
    //Fonction qui permet de créer, ou récupérer un type d'aliment pour le modifier
    public function ajoutModificationType(Type $type = null, Request $request, EntityManagerInterface $entityManager)
    {
        if (!$type){
            $type = new Type();
        }
        $form=$this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $type->getId() !== null; 
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash("success", $modif ? "La modification a été effectuée" : "L'ajout a été effectuée");
            return $this->redirectToRoute("admin_types");
        }
        return $this->render('admin/adminTypes/ajoutModificationType.html.twig', [
            "type"=>$type,
            "form"=>$form->createView(),
            "isModification" => $type->getId() !== null 
        ]);
    }

    /**
     * @Route("/admin/types/{id}", name="admin_admin_suppression_type", methods="delete")
     */
    //Fonction permettant de supprimer un type d'aliment
    public function suppressionTypeAliment(Type $type, Request $request, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid("SUPR". $type->getId(), $request->get('_token'))){
        //On prépare la requête de suppression avec remove() et on envoie en BDD avec flush()
        $entityManager->remove($type);
        $entityManager->flush();
        $this->addFlash("success","La suppression a été effectuée");
        return $this->redirectToRoute("admin_types");
        }
    }

}
