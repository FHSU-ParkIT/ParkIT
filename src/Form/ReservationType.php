<?php

namespace App\Form;

use App\Entity\LicensePlate;
use App\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Date;

class ReservationType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hours = [
            0=>'12am',
            1=>'1am',
            2=>'2am',
            3=>'3am',
            4=>'4am',
            5=>'5am',
            6=>'6am',
            7=>'7am',
            8=>'8am',
            9=>'9am',
            10=>'10am',
            11=>'11am',
            12=>'12pm',
            13=>'1pm',
            14=>'2pm',
            15=>'3pm',
            16=>'4pm',
            17=>'5pm',
            18=>'6pm',
            19=>'7pm',
            20=>'8pm',
            21=>'9pm',
            22=>'10pm',
            23=>'11pm',
        ];

        $timeOptions = ['minutes' => [0,15,30,45], ];

            $builder
            ->add('startDateTime', DateTimeType::class, $timeOptions
            )
            ->add('endDateTime', DateTimeType::class, $timeOptions)
            ->add('licensePlate', EntityType::class, [
                'class' => LicensePlate::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.User = ?1')
                        ->setParameter('1', $this->security->getUser());
                },
                'choice_label' => function ($licensePlate) {
                    return $licensePlate->getPlateNumber();
                },
            ])
            //->add('parkingSpot')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
