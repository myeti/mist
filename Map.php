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
class Map
{

    /** @var \mist\API */
    public $_api;


    /**
     * Build with API
     * @param API $api
     */
    public function __construct(API $api)
    {
        $this->_api = $api;
    }


    /**
     * Find LatLng
     * @param $search
     * @return \mist\Location
     */
    public function find($search)
    {
        return $this->_api->find($search);
    }


    /**
     * Find path between two points
     * @param $from
     * @param $to
     * @return array
     */
    public function path($from, $to)
    {
        return $this->_api->path($from, $to);
    }


    /**
     * Alias of display : echo $map;
     * @return mixed
     */
    public function __toString()
    {
        return $this->_api->display();
    }


    /**
     * Alias of display : echo $map('Annecy');
     * @param $location
     * @return mixed
     */
    public function __invoke($location)
    {
        return $this->_api->display($location);
    }

}