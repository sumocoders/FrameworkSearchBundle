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
}
