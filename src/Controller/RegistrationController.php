<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // handle submit on POST if the form is submitted and also valid:
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Encode password
            $password = $passwordEncoder->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->eraseCredentials(); // Removes plain password


            // Save new user account
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/index.html.twig', [
            'headerTitle' => 'Register',
            'form'=> $form->createView(),
        ]);
    }

}
