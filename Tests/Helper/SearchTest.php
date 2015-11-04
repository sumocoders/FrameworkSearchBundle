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
        $eventResult = array(new SearchResult(
            '\Some\Class',
            12,
            'TestBundle',
            'Test',
            'test'
        ));
        $repository = $this->getRepositoryMock($sqlResult);
        $eventDispatcher = $this->getEventDispatcherMock($eventResult);

        $search = new Search($repository, $eventDispatcher, 'test');
        $search->search();
        $results = $search->getResults();

        // our item should still be here, because it's found in both sql and event
        $this->assertCount(1, $results);

        // the weight should be available in our resultset
        $this->assertEquals(2, $results[0]->getWeight());

        // our item should still have the same id, class and title
        $this->assertEquals($eventResult[0]->getId(), $results[0]->getId());
        $this->assertEquals($eventResult[0]->getClass(), $results[0]->getClass());
        $this->assertEquals($eventResult[0]->getTitle(), $results[0]->getTitle());
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
                function ($eventName, $event) use ($eventResult) {
                    foreach ($eventResult as $item) {
                        $event->addResult($item);
                    }
                }
            ));

        return $eventDispatcher;
    }
}
