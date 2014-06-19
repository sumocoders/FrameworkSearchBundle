<?php

namespace SumoCoders\FrameworkSearchBundle\Entity;

class SearchResult
{
    /**
     * @var string
     */
    protected $bundle;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @param string $class
     * @param string $id
     * @param string $bundle
     * @param string $title
     * @param string $route
     */
    public function __construct($class, $id, $bundle, $title, $route)
    {
        $this->setClass($class);
        $this->setId($id);
        $this->setBundle($bundle);
        $this->setTitle($title);
        $this->setRoute($route);
    }

    /**
     * @param string $bundle
     */
    protected function setBundle($bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @param string $class
     */
    protected function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $id
     */
    protected function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $route
     */
    protected function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $title
     */
    protected function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
