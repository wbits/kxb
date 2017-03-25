<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wbits\Kxb\Admin\Controller\Dto\CreateArtPieceRequest;

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
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CreateArtPieceRequest::class,
        ));
    }
}
