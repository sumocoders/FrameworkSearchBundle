<?php

namespace SumoCoders\FrameworkSearchBundle\Tests\Entity;

use SumoCoders\FrameworkSearchBundle\Entity\IndexItem;

class IndexItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SumoCoders\FrameworkSearchBundle\Entity\IndexItem
     */
    private $indexItem;

    /**
     * @var array
     */
    private $defaultData = array(
        'objectType' => 'User',
        'otherId' => 1,
        'field' => 'nickname',
        'value' => 'J. Doe',
    );

    /**
     * Test the getters and setters
     */
    public function testGettersAndSetters()
    {
        $this->indexItem = new IndexItem(
            $this->defaultData['objectType'],
            $this->defaultData['otherId'],
            $this->defaultData['field'],
            $this->defaultData['value']
        );

        $this->assertEquals($this->defaultData['objectType'], $this->indexItem->getObjectType());
        $this->assertEquals($this->defaultData['otherId'], $this->indexItem->getOtherId());
        $this->assertEquals($this->defaultData['field'], $this->indexItem->getField());
        $this->assertEquals($this->defaultData['value'], $this->indexItem->getValue());
    }

    public function testCreateMultipleObjectsBasedOnProperties()
    {
        $properties = array(
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'nickname' => 'J. Doe',
        );

        $fakeObject = new \stdClass();
        $fakeObject->name = 'John';
        $fakeObject->surname = 'Doe';
        $fakeObject->email = 'john.doe@example.com';
        $fakeObject->nickname = 'J. Doe';

        $indexItems = IndexItem::createMultipleObjectsBasedOnProperties(
            $this->defaultData['objectType'],
            $this->defaultData['otherId'],
            array_keys($properties),
            $fakeObject
        );

        foreach ($indexItems as $index) {
            /** @var SumoCoders\FrameworkSearchBundle\Entity\IndexItem $index*/
            $this->assertInstanceOf('\SumoCoders\FrameworkSearchBundle\Entity\IndexItem', $index);
            $this->assertEquals($properties[$index->getField()], $index->getValue());
        }
    }

    public function testCreateMultipleObjectsBasedOnPropertiesFromObject()
    {
        $properties = array(
            'name' => 'John',
            'surname' => 'Doe',
        );
        $object = new Person('John', 'Doe');

        $indexItems = IndexItem::createMultipleObjectsBasedOnProperties(
            $this->defaultData['objectType'],
            $this->defaultData['otherId'],
            array_keys($properties),
            $object
        );

        foreach ($indexItems as $index) {
            /** @var SumoCoders\FrameworkSearchBundle\Entity\IndexItem $index*/
            $this->assertInstanceOf('\SumoCoders\FrameworkSearchBundle\Entity\IndexItem', $index);
            $this->assertEquals($properties[$index->getField()], $index->getValue());
        }
    }
}

/**
 * Test class to test building an index item from a real object
 */
final class Person
{
    private $name;
    private $surname;

    /**
     * @param string $name
     * @param string $surname
     */
    public function __construct($name, $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }
}
