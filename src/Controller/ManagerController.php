<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manage", name="manage-")
 */
class ManagerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('manage/index.html.twig', [
            'headerTitle' => 'Welcome!'
        ]);
    }
}
