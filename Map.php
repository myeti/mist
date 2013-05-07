<?php

/**
 * This file is part of Mist.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 *
 * @date 2013-05-07
 * @author Aymeric Assier <aymeric.assier@gmail.com>
 * @version 0.1
 */
namespace mist;

/**
 * Master class
 * Class Map
 * @package mist
 */
class Map implements API
{

    /** @var \mist\API */
    public $_service;


    /**
     * Build with Service
     * @param API $service
     */
    public function __construct(API $service)
    {
        $this->_service = $service;
    }


    /**
     * Find LatLng
     * @param $search
     * @return \mist\Location
     */
    public function find($search)
    {
        return $this->_service->find($search);
    }


    /**
     * Find path between two points
     * @param $from
     * @param $to
     * @return array
     */
    public function path($from, $to)
    {
        return $this->_service->path($from, $to);
    }


    /**
     * Display map
     * @param null $location
     * @return mixed
     */
    public function display($location = null)
    {
        return $this->_service->display($location);
    }


    /**
     * Alias of display : echo $map;
     * @return mixed
     */
    public function __toString()
    {
        return $this->display();
    }


    /**
     * Alias of display : echo $map('Annecy');
     * @param $location
     * @return mixed
     */
    public function __invoke($location)
    {
        return $this->display($location);
    }

}