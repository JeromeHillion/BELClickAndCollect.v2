<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $user->setDateCreated(new DateTime('now'));

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();



        //Si le formulaire est soumis et valide on enregistre dans notre base données

        if ($form->isSubmitted() && $form->isValid()) {
            //avant d'enregistrer on prépare le hash du mot de passe
             $hash = $encoder->encodePassword($user, $user->getPassword());

            //On récupère le mot de passe pour le hacher avant insertion dans la base de donnée
            $user->setPassword($hash);
            $entityManager->persist($user);
            $entityManager->flush();

            //On redirige vers la page de login
            return $this->redirectToRoute("security_login");
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render("security/login.html.twig");
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){

    }



}
