<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reserveSpot", name="reserveSpot")
     */
    public function index()
    {
        return $this->render('reservation/index.html.twig');
    }
}
