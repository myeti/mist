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
 * API Service contract
 * Class API
 * @package mist
 */
interface API
{

    /**
     * Find LatLng from address
     * @param $search
     * @return \mist\Location
     */
    public function find($search);

    /**
     * Find path between two points
     * @param $from
     * @param $to
     * @return array
     */
    public function path($from, $to);

    /**
     * Display map
     * @param null $search
     * @return string
     */
    public function display($search = null);

}