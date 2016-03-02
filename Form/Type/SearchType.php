<?php

namespace SumoCoders\FrameworkSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'term',
                TextType::class,
                array(
                    'widget_addon_prepend' => array(
                        'icon' => 'search',
                    ),
                    'label' => 'search.forms.labels.term',
                    'label_attr' => array(
                        'class' => 'hidden',
                    ),
                    'constraints' => array(
                        new NotBlank(),
                    ),
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'horizontal' => false,
            )
        );
    }
}
