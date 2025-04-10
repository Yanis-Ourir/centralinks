<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Link;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('url')
            ->add('applicationName')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function ($er) use ($user) {
                    return $er->createQueryBuilder('c')
                        ->where('c.owner = :owner')
                        ->setParameter('owner', $user);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
            'user' => null,
        ]);
    }
}
