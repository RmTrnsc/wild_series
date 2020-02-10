<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('summary', TextareaType::class)
            ->add('poster', UrlType::class)
            ->add('category', null, [
                'choice_label' => 'name'
            ])
            ->add('actors', EntityType::class, [
                    'class' => Actor::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.name', 'asc');
                    },
                    'multiple' => true,
                    'expanded' => true,
                    'choice_label' => 'name',
                    'by_reference' =>false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
