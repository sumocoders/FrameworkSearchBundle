<?php

namespace SumoCoders\FrameworkSearchBundle\Tests\Form\Type;

use SumoCoders\FrameworkSearchBundle\Form\Type\SearchType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Validator\ConstraintViolationList;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetFormTypeExtension;

class SearchTypeTest extends TypeTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->getMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtension(
                new FormTypeValidatorExtension($validator)
            )
            ->addTypeExtension(
                new WidgetFormTypeExtension(array('checkbox_label' => 'label'))
            )
            ->getFormFactory();
    }

    public function testSubmitValidData()
    {
        $formData = array('term' => 'wouter');

        $form = $this->factory->create(SearchType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
