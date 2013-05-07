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
 * Define a location
 * Class Location
 * @package mist
 */
class Location
{

    /** @var float */
    public $lat;

    /** @var float */
    public $lng;

    /** @var string */
    public $street;

    /** @var string */
    public $postcode;

    /** @var string */
    public $city;

    /** @var string */
    public $state;

    /** @var string */
    public $county;

    /** @var string */
    public $country;

    /** @var mixed */
    public $other;

}