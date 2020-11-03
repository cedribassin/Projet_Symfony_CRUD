<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //On récupère le password et on l'encrypte
            $passwordCrypte = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            //On modifie le password avec son setter:
            $utilisateur->setPassword($passwordCrypte);
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute("aliments");
        }
        return $this->render('admin_secu/inscription.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="connexion")
     */
    public function login(AuthenticationUtils $utils){
        return $this->render('admin_secu/login.html.twig', [
            "lastUserName"=>$utils->getLastUsername(),
            "error"=>$utils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(){
    }

}
