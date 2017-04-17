<?php

namespace SumoCoders\FrameworkSearchBundle\Tests\Helper;

use SumoCoders\FrameworkSearchBundle\Helper\Search;
use SumoCoders\FrameworkSearchBundle\Entity\SearchResult;

class SearchTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccesfullSearch()
    {
        $sqlResult = array(
            '\Some\Class' => array(12 => 2),
        );
        $eventResult = array(
            new SearchResult('\Some\Class', 12, 'TestBundle', 'Test', 'test')
        );
        $repository = $this->getRepositoryMock($sqlResult);
        $eventDispatcher = $this->getEventDispatcherMock($eventResult);

        $search = new Search($repository, $eventDispatcher, 'test');
        $results = $search->search();

        // our item should still be here, because it's found in both sql and event
        $this->assertCount(1, $results);

        // the weight should be available in our resultset
        $this->assertEquals(2, $results[0]->getWeight());

        // our item should still have the same id, class and title
        $this->assertEquals($eventResult[0]->getId(), $results[0]->getId());
        $this->assertEquals($eventResult[0]->getClass(), $results[0]->getClass());
        $this->assertEquals($eventResult[0]->getTitle(), $results[0]->getTitle());
    }

    public function testSearchNoEventResults()
    {
        $sqlResult = array(
            '\Some\Class' => array(12 => 2),
        );
        $eventResult = array();
        $repository = $this->getRepositoryMock($sqlResult);
        $eventDispatcher = $this->getEventDispatcherMock($eventResult);

        $search = new Search($repository, $eventDispatcher, 'test');
        $results = $search->search();

        // our item does not exist anymore
        $this->assertCount(0, $results);
    }

    public function testSearchWrongSorting()
    {
        $sqlResult = array(
            '\Some\Class' => array(3 => 1, 12 => 2),
        );
        $eventResult = array(
            new SearchResult('\Some\Class', 3, 'TestBundle', 'Test', 'test'),
            new SearchResult('\Some\Class', 12, 'TestBundle', 'Test', 'test')
        );
        $repository = $this->getRepositoryMock($sqlResult);
        $eventDispatcher = $this->getEventDispatcherMock($eventResult);

        $search = new Search($repository, $eventDispatcher, 'test');
        $results = $search->search();

        // our items should still be here, because they are found in both sql and event
        $this->assertCount(2, $results);

        // the order should be from high weight to low weight
        $this->assertEquals(2, $results[0]->getWeight());
        $this->assertEquals(1, $results[1]->getWeight());
    }

    public function testSearchCorrectSorting()
    {
        $sqlResult = array(
            '\Some\Class' => array(3 => 1, 4 => 1),
            '\Other\Class' => array(12 => 2),
        );
        $eventResult = array(
            new SearchResult('\Some\Class', 3, 'TestBundle', 'Test', 'test'),
            new SearchResult('\Some\Class', 4, 'TestBundle', 'Test', 'test'),
            new SearchResult('\Other\Class', 12, 'TestBundle', 'Test', 'test')
        );
        $repository = $this->getRepositoryMock($sqlResult);
        $eventDispatcher = $this->getEventDispatcherMock($eventResult);

        $search = new Search($repository, $eventDispatcher, 'test');
        $results = $search->search();

        // our items should still be here, because they are found in both sql and event
        $this->assertCount(3, $results);

        // the order should be from high weight to low weight
        $this->assertEquals(2, $results[0]->getWeight());
        $this->assertEquals(1, $results[1]->getWeight());
        $this->assertEquals(1, $results[2]->getWeight());
    }

    private function getRepositoryMock($sqlResult)
    {
        $repository = $this->getMockBuilder('SumoCoders\FrameworkSearchBundle\Entity\IndexItemRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $repository->method('search')->willReturn($sqlResult);

        return $repository;
    }

    private function getEventDispatcherMock($eventResult)
    {
        $eventDispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcherInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcher->method('dispatch')
            ->will($this->returnCallback(
                function($eventName, $event) use ($eventResult) {
                    foreach ($eventResult as $item) {
                        $event->addResult($item);
                    }
                }
            ));

        return $eventDispatcher;
    }
}
