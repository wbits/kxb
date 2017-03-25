<?php

declare(strict_types = 1);

namespace Controller\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class ArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('material')
            ->add('width')
            ->add('height')
            ->add('year')
            ->add('number_of_copies')
            ->add('price')
            ->add('artist')
        ;
    }
}
