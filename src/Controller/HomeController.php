<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        
        return $this->render('home/index.html.twig', [
            'headerTitle' => 'Welcome!'
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('home/login.html.twig',[
            'headerTitle' => 'Login'
        ]);
    }

}
