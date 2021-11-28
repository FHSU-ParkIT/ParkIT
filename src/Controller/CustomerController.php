<?php

namespace App\Controller;

use App\Entity\LicensePlate;
use App\Entity\ParkingSpot;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\LicensePlateType;
use App\Form\ReservationType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        $userEmail = $this->security->getUser()->getUsername();
        $userRepository = $this->getDoctrine()->getRepository(User::class);


        /** @var User $user */
        $user = $userRepository->findOneByEmail($userEmail);

//        If user does not have a license plate, redirect them to create License Plate
       if(count($user->getLicensePlates()) === 0){
           return $this->redirectToRoute('customer_add_license_plate', ['redirectTo'=>'customer_make_reservation']);
       }

        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        ;
        if($form->isSubmitted() && $form->isValid()){
            $parkingSpotRepository = $this->getDoctrine()->getRepository(ParkingSpot::class);
            $reservationRepository= $this->getDoctrine()->getRepository(Reservation::class);


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

    /**
     *
     * @Route("/profile", name="profile_management")
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profile Updated!');
            return $this->redirectToRoute('customer_profile_management');
        }

        return $this->render('customer/profile-management.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/plate-management", name="license_plate_management")
     * @return Response
     */
    public function manageLicensePlates(Request $request): Response
    {

        $licensePlateRepository = $this->getDoctrine()->getRepository(LicensePlate::class);

        if($request->query->get('removeLicensePlate'))
        {
            $plateId = $request->query->get('removeLicensePlate');
            // Find licenseplate within database
            $licensePlate = $licensePlateRepository->findBy(['id'=>$plateId]);

            if(count($licensePlate) === 1) {
                $entityManager = $this->getDoctrine()->getManager();
                try{

                    $entityManager->remove($licensePlate[0]);
                    $entityManager->flush();
                    $this->addFlash('success', 'License plate successfully removed.');
                }
                catch(\Exception $exception){
                    // Add additional error handling if the need arises
                    $this->addFlash('danger', 'Something went wrong...');
                }
                return $this->redirectToRoute('customer_license_plate_management');
            };
        }
        $userLicensePlates = $licensePlateRepository->findByUserField($this->security->getUser());

        return $this->render('customer/license-plate-management.html.twig',[
            'licensePlates' => $userLicensePlates,
        ]);
    }

    /**
     * @Route("/add-license-plate", name="add_license_plate")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addLicensePlate(Request $request, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(LicensePlateType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var LicensePlate $plate */
            $plate = $form->getData();
            $userEmail = $this->security->getUser()->getUsername();
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneByEmail($userEmail);
            $plate->setUser($user);
            try{
                $entityManager->persist($plate);
                $entityManager->flush();
                $this->addFlash('success', 'License plate successfully added.');
            }
            catch(\Exception $exception){
                // Add additional error handling if the need arises
                $this->addFlash('danger', 'Something went wrong...');

                return $this->render('customer/add-license-plate.html.twig',[
                    'licensePlateForm'=>$form->createView(),
                ]);

            }
            if($request->query->get('redirectTo')){
                return $this->redirectToRoute($request->query->get('redirectTo'));
            }
            return $this->redirectToRoute('customer_license_plate_management');

        }

        return $this->render('customer/add-license-plate.html.twig',[
            'licensePlateForm'=>$form->createView(),
        ]);
    }

}
