<?php

namespace App\Controller;

use App\Entity\ParkingSpot;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/customer", name="customer_")
 */
class CustomerController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {

        $userEmail = $this->security->getUser()->getUsername();
        /** @var User $user */
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByEmail($userEmail)
        ;
        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findByUserId($user->getId())
        ;
        dump($reservations);

        return $this->render('customer/index.html.twig', [
            'reservations' => $reservations
        ]);
    }


    /**
     * @Route("/make-reservation", name="make_reservation")
     */
    public function makeReservation(Request $request): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        ;
        if($form->isSubmitted() && $form->isValid()){
            $userEmail = $this->security->getUser()->getUsername();
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $parkingSpotRepository = $this->getDoctrine()->getRepository(ParkingSpot::class);
            $reservationRepository= $this->getDoctrine()->getRepository(Reservation::class);

            $user = $userRepository->findOneByEmail($userEmail);

            $licensePlate =  $reservation->getLicensePlate();
            $licensePlate->setUser($user); // Adds user to the added license plate.
            $reservation->setUser($user);

            $parkingSpotId = $parkingSpotRepository->findRandomParkingSpotAndReturnId();

        $possibleReservation = $reservationRepository->findByParkingSpotId($parkingSpotId);

        // If there is no possible reservation, proceed (currently)
            // TODO: We need to add a more safety to this by looping and checking for other spots if the first
            //  one happens to be reserved. If all of the spots that exist have been exhausted, then repeat the process
            //      checking times.
        if($possibleReservation === []){
            $parkingSpot = $this->getDoctrine()->getRepository(ParkingSpot::class)->findOneById($parkingSpotId);
            $reservation->setParkingSpot($parkingSpot);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation->getLicensePlate());
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Your reservation has been made.');

            // Add to message bag with a hip hip hooray
            return $this->redirectToRoute('customer_index');
        }
        else{
            $this->addFlash('error', 'Could not create reservation at this time');
        }

        }

        return $this->render('customer/make-reservation.html.twig', [
            'reservationForm' => $form->createView(),
        ]);
    }
}
