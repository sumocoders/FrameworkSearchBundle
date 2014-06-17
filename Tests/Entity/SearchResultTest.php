<?php

namespace SumoCoders\FrameworkSearchBundle\Tests\Entity;

use SumoCoders\FrameworkSearchBundle\Entity\SearchResult;

class SearchResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SumoCoders\FrameworkSearchBundle\Entity\SearchResult
     */
    private $searchResult;

    /**
     * @var array
     */
    private $defaultData = array(
        'class' => 'User',
        'id' => 1,
        'bundle' => 'users',
        'title' => 'J. Doe',
        'route' => '/en/users/1',
        'weight' => 100,
    );

    /**
     * Test the getters and setters
     */
    public function testGettersAndSetters()
    {
        $this->searchResult = new SearchResult(
            $this->defaultData['class'],
            $this->defaultData['id'],
            $this->defaultData['bundle'],
            $this->defaultData['title'],
            $this->defaultData['route']
        );
        $this->searchResult->setWeight($this->defaultData['weight']);

        $this->assertEquals($this->defaultData['class'], $this->searchResult->getClass());
        $this->assertEquals($this->defaultData['id'], $this->searchResult->getId());
        $this->assertEquals($this->defaultData['bundle'], $this->searchResult->getBundle());
        $this->assertEquals($this->defaultData['title'], $this->searchResult->getTitle());
        $this->assertEquals($this->defaultData['route'], $this->searchResult->getRoute());
        $this->assertEquals($this->defaultData['weight'], $this->searchResult->getWeight());
    }
}
