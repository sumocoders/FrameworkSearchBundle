<?php

namespace SumoCoders\FrameworkSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
                'q',
                'text',
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'horizontal' => false,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
