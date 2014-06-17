<?php

namespace SumoCoders\FrameworkSearchBundle\Event;

use SumoCoders\FrameworkSearchBundle\Entity\SearchResult;
use Symfony\Component\EventDispatcher\Event;

class SearchEvent extends Event
{
    /**
     * @var array
     */
    protected $foundItems = array();

    /**
     * @var array
     */
    protected $results = array();

    /**
     * @param array $foundItems
     */
    public function setFoundItems(array $foundItems)
    {
        $this->foundItems = $foundItems;
    }

    /**
     * @return mixed
     */
    public function getFoundItems()
    {
        return $this->foundItems;
    }

    /**
     * @param string $class
     * @return array
     */
    public function getFoundIdsForClass($class)
    {
        if (!array_key_exists($class, $this->foundItems)) {
            return array();
        }

        return $this->foundItems[$class];
    }

    /**
     * @param SearchResult $result
     */
    public function addResult(SearchResult $result)
    {
        $class = $result->getClass();
        $id = $result->getId();

        $this->results[$class][$id] = $result;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }
}
