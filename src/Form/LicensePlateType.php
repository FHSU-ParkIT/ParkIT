<?php

namespace App\Form;

use App\Entity\LicensePlate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class LicensePlateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plateNumber', TextType::class, [
                'label'=> 'Plate Number',
                'constraints' => [
                    new Length(['max'=>8])
                ]
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LicensePlate::class,
        ]);
    }
}
