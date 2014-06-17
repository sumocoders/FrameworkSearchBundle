<?php

namespace SumoCoders\FrameworkSearchBundle\Tests\Event;

use SumoCoders\FrameworkSearchBundle\Entity\IndexItem;
use SumoCoders\FrameworkSearchBundle\Event\IndexEvent;

class IndexEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create an IndexItem
     *
     * @return IndexItem
     */
    protected function createIndexItem()
    {
        $indexItem = new IndexItem(
            'User',
            1,
            'nickname',
            'J. Doe'
        );

        return $indexItem;
    }

    /**
     * Test the getters and setters
     */
    public function testGettersAndSetters()
    {
        $indexEvent = new IndexEvent();

        $objects = array(
            $this->createIndexItem(),
            $this->createIndexItem(),
            $this->createIndexItem(),
        );
        $extraObject = $this->createIndexItem();

        $indexEvent->setObjects($objects);
        $indexEvent->addObject($extraObject);

        $fetchedObjects = $indexEvent->getObjects();
        $expectedObjects = $objects;
        $expectedObjects[] = $extraObject;

        $this->assertEquals($expectedObjects, $fetchedObjects);
    }
}
