<?php

namespace SumoCoders\FrameworkSearchBundle\Helper;

use SumoCoders\FrameworkSearchBundle\Entity\IndexItemRepository;
use SumoCoders\FrameworkSearchBundle\Entity\SearchResult;
use SumoCoders\FrameworkSearchBundle\Event\SearchEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Search
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected $term;

    /**
     * @var \SumoCoders\FrameworkSearchBundle\Entity\IndexItemRepository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $results = array();

    /**
     * @param IndexItemRepository      $repository
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $term
     */
    public function __construct(
        IndexItemRepository $repository,
        EventDispatcherInterface $eventDispatcher,
        $term = null
    ) {
        $this->setRepository($repository);
        $this->setEventDispatcher($eventDispatcher);

        if ($term) {
            $this->setTerm($term);
        }
    }

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return mixed
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param \SumoCoders\FrameworkSearchBundle\Entity\IndexItemRepository $repository
     */
    public function setRepository(IndexItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \SumoCoders\FrameworkSearchBundle\Entity\IndexItemRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param array $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Executes the real search
     */
    public function search()
    {
        // grab the ids and their number of occurence from the search index
        $idsAndWeightsPerClass = (array) $this->getRepository()->search($this->getTerm());

        // process the results, and sort them by weight/class
        $foundItems = array();
        foreach ($idsAndWeightsPerClass as $class => &$row) {
            arsort($row);
            $foundItems[$class] = array_keys($row);
        }

        // create the event, and add our findings
        $event = new SearchEvent();
        $event->setFoundItems($foundItems);
        $this->getEventDispatcher()->dispatch('search.search', $event);

        // sort the results based on their weights
        $results = $event->getResults();
        $sortedResults = $this->sortResults($idsAndWeightsPerClass, $results);

        $this->setResults($sortedResults);
    }

    /**
     * Sort the results
     *
     * @param array $idsAndWeightsPerClass
     * @param array $results
     * @return array
     */
    protected function sortResults(array $idsAndWeightsPerClass, array $results)
    {
        $sortedItems = array();

        foreach ($idsAndWeightsPerClass as $class => $ids) {
            if (isset($results[$class])) {
                foreach ($ids as $id => $weight) {
                    if (isset($results[$class][$id])) {
                        $result = $results[$class][$id];
                        $result->setWeight($weight);
                        $sortedItems[] = $result;
                    }
                }
            }
        }

        usort(
            $sortedItems,
            function (SearchResult $result1, SearchResult $result2) {
                if ($result1->getWeight() < $result2->getWeight()) {
                    return 1;
                }
                if ($result1->getWeight() > $result2->getWeight()) {
                    return -1;
                }

                return 0;
            }
        );

        return $sortedItems;
    }
}
