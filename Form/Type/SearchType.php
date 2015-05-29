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
                'label' => 'search.forms.labels.term',
                'constraints' => array(
                    new NotBlank(),
                ),
            )
        )
            ->add(
                'search',
                'submit',
                array(
                    'label' => 'search.forms.buttons.search',
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
