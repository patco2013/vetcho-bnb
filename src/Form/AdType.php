<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     * Allows you to have the basic configuration of a control / Permet d'avoir la configuration de base d'un champs
     *
     * @param [type] $label
     * @param [type] $placeholder
     * @return void
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Mettez un super titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse web", "Tapez votre adresse web (automatique)"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image", "Mettez l'url d'une photo qui donne vraiment envie"))
            ->add('introduction', TextType::class, $this->getConfiguration("Description", "Donner une description globale de l'annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description détaillée", "Tapez une description détaillée de votre annonce"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambre", "Nombre de chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix", "Mettez le prix"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
