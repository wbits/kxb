<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Admin\Controller\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wbits\Kxb\Admin\Controller\Dto\ArtForm;

final class ArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artistId',
                ChoiceType::class,
                [
                    'choices' => $builder->getData()->getArtistChoices(),
                    'placeholder' => 'Choose an Artist',
                    'label' => 'Artist'
                ]
            )
            ->add('title')
            ->add('material')
            ->add('width')
            ->add('height')
            ->add('year')
            ->add('numberOfCopies', TextType::class, ['label' => 'Availability'])
            ->add('price')
            ->add('attachments', FileType::class, ['multiple' => true])
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ArtForm::class,
        ));
    }
}
