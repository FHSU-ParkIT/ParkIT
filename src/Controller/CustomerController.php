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

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByEmail($userEmail)
            ;

            $licensePlate =  $reservation->getLicensePlate();
            $licensePlate->setUser($user); // Adds user to the added license plate.
            $reservation->setUser($user);

            $sql = <<<'SQL'
select id from parking_spot order by RAND() limit 1
SQL;

        $entityManager = $this->getDoctrine()->getManager();
        $statement = $entityManager->getConnection()->prepare($sql);
        $statement->execute();
        $parkingSpotId = $statement->fetchAll()[0];

        $possibleReservation = $entityManager->getRepository(Reservation::class)->findByParkingSpotId($parkingSpotId['id']);


        // If there is no possible reservation, proceed
        if($possibleReservation === []){
            $parkingSpot = $entityManager->getRepository(ParkingSpot::class)->findOneById($parkingSpotId['id']);
            $reservation->setParkingSpot($parkingSpot);

            $entityManager->persist($reservation->getLicensePlate());
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Your reservation has been made.');

            // Add to message bag with a hip hip hooray
            return $this->redirectToRoute('customer_index');
        }

        }

        return $this->render('customer/make-reservation.html.twig', [
            'reservationForm' => $form->createView(),
        ]);
    }
}
