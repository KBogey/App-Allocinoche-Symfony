<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Movie;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre de la pellicule'])
            ->add('releasedAt', DateType::class, [
                'label' => 'Date de sortie',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('duration', IntegerType::class, ['label' => 'Durée en min'])
            ->add('director', EntityType::class, [
                'label' => 'Réalisateur',
                'class' => Director::class,
                'choice_label' => function (Director $director) {
                    return $director->getFirstName() . ' ' . $director->getLastName();
                }
            ])
            ->add('actors', EntityType::class, [
                'label' => "Casting",
                'class' => Actor::class,
                'choice_label' => function (Actor $actor) {
                    return $actor->getFirstName() . ' ' . $actor->getLastName();
                },
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => "Genres",
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('description', TextareaType::class, ['label' => 'Synopsis'])
            ->add('imageUrl', TextType::class, ['label' => 'Url d\'une image relative au film']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
