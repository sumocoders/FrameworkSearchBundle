<?php

namespace SumoCoders\FrameworkSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'q',
            'text',
            array(
                'label' => 'forms.search.labels.search',
                'constraints' => array(
                    new NotBlank(),
                ),
            )
        )
            ->add(
                'search',
                'submit',
                array(
                    'label' => 'forms.search.buttons.search',
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
