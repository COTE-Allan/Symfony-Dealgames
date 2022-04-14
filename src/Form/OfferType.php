<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', NULL, [
                "label" => "Nom de l'offre"
            ])
            ->add('description', NULL, [
                "label" => "Description"
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                "label" => "Choisissez une catégorie",
                'choice_label' => "name",
                "multiple" => false,
                "expanded" => true,
                'row_attr' => [
                    "class" => "radio",
                ]
            ])
            ->add('photoFile', VichImageType::class, [
                "label" => "Ajoutez une photo"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
