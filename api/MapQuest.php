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
namespace mist\api;

use mist\API;
use mist\Location;

/**
 * MapQuest service API
 * Class MapQuest
 * @package mist\api
 */
class MapQuest implements API
{

    /** @var string */
    protected $_apiKey;

    /** @var string */
    protected $_urlFind = 'http://www.mapquestapi.com/geocoding/v1/address?key={API_KEY}&location={SEARCH}';

    /** @var string */
    protected $_urlPath= 'http://www.mapquestapi.com/directions/v1/route?key={API_KEY}&from={FROM}&to={TO}';


    /**
     * Create Map with api key
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->_apiKey = $apiKey;
    }


    /**
     * Find LatLng from address
     * @param $search
     * @return \mist\Location
     */
    public function find($search)
    {
        // build url
        $url = str_replace('{API_KEY}', $this->_apiKey, $this->_urlFind);
        $url = str_replace('{SEARCH}', urlencode($search), $url);

        // make request
        $data = json_decode(static::get($url));

        // error
        if(empty($data->results[0]->locations[0]))
            return false;

        // walk to necessary info
        $data = $data->results[0]->locations[0];

        return static::parse($data);
    }


    /**
     * Find path between two points
     * @param $from
     * @param $to
     * @return array
     */
    public function path($from, $to)
    {
        // build url
        $url = str_replace('{API_KEY}', $this->_apiKey, $this->_urlPath);
        $url = str_replace('{FROM}', urlencode($from), $url);
        $url = str_replace('{TO}', urlencode($to), $url);

        // make request
        $data = json_decode(static::get($url));

        // error
        if(empty($data->collections))
            return false;

        // make route
        $route = [];
        foreach($data->collections as $collection)
            foreach($collection as $row)
                $route[] = static::parse($row);

        return $route;
    }


    /**
     * Display map
     * @param null $search
     * @return mixed|void
     */
    public function display($search = null)
    {
        // default location : Annecy, FR
        $location = new Location();
        $location->lat = '45.899267';
        $location->lng = '6.130672';

        // user location
        if($search)
            $location = $this->find($search);

        $html = '
            <script src="http://www.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js?key=' . $this->_apiKey . '"></script>
            <script type="text/javascript">

                MQA.EventUtil.observe(window, "load", function() {

                    var options={
                        elt:document.getElementById("map"),
                        zoom:12,
                        latLng:{lat:' . $location->lat . ', lng:' . $location->lng . '},
                        mtype:"map",
                        bestFitMargin:0,
                        zoomOnDoubleClick:true
                    };

                    window.map = new MQA.TileMap(options);

                });

            </script>
            <div id="map" style="width:800px; height:600px;"></div>
        ';

        return $html;
    }


    /**
     * Execute async request
     * @author Pampa22
     * @param $url
     * @return mixed
     */
    protected static function get($url)
    {
        $ch = curl_init();

        @curl_setopt($ch, CURLOPT_URL, $url);
        @curl_setopt($ch, CURLOPT_POST, false);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_HEADER, false);
        @curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        @curl_setopt($ch, CURLOPT_VERBOSE, true);

        $result = @curl_exec($ch);

        @curl_close($ch);

        return $result ?: false;
    }


    /**
     * Create Location from data parsing
     * @param \stdClass $data
     * @return Location
     */
    protected static function parse(\stdClass $data)
    {
        // create location
        $location = new Location();
        $location->lat = $data->latLng->lat;
        $location->lng = $data->latLng->lng;
        $location->street = utf8_decode($data->street);
        $location->postcode = utf8_decode($data->postalCode);

        // field
        $fields = ['adminArea1', 'adminArea3', 'adminArea4', 'adminArea5'];
        foreach($fields as $field) {
            $type = strtolower($data->{$field . 'Type'});
            $location->{$type} = utf8_decode($data->{$field});
        }

        return $location;
    }

}