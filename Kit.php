<?php

namespace mist;

abstract class Kit implements API
{

    /** @var array  */
    protected $_places = [];

    /** @var array  */
    protected $_roads = [];

    /** @var  string */
    protected $_mapfile;


    /**
     * Force setup in constructor
     */
    public function __construct()
    {
        $this->setup();
    }


    /**
     * Setup cities and roads
     */
    protected abstract function setup();


    /**
     * Add a place
     * @param $name
     * @param mixed $location
     * @throws \InvalidArgumentException
     * @return $this
     */
    protected function place($name, $location = null)
    {
        // default location to name only
        if(!$location)
            $this->_places[$name] = new Location(['city' => $name]);

        // location object
        elseif($location instanceof Location)
            $this->_places[$name] = $location;

        // latlng input
        elseif(is_array($location) and count($location) == 2)
            $this->_places[$name] = new Location(['city' => $name, 'lat' => $location[0], 'lng' => $location[1]]);

        // error
        else
            throw new \InvalidArgumentException;

        return $this;
    }


    /**
     * Add road between cities
     * @param string $from
     * @param string $to
     * @param int $value
     * @return $this
     */
    protected function road($from, $to, $value = 1)
    {
        // first way
        if(!isset($this->_roads[$from]))
            $this->_roads[$from] = [];

        $this->_roads[$from][$to] = $value;

        // way back
        if(!isset($this->_roads[$to]))
            $this->_roads[$to] = [];

        $this->_roads[$to][$from] = $value;

        return $this;
    }


    /**
     * Graph oriented pathfinder
     * @param $current
     * @param $to
     * @param array $road
     * @param array $exclude
     * @param int $step
     * @return array
     */
    protected function pathfinder($current, $to, array $road = [], array $exclude = [], $step = 0)
    {
        // add to road
        $road[] = $this->_places[$current];

        // found ?
        if($current == $to)
            return [$road, $step];

        // no way to target found
        if(empty($this->_roads[$current]))
            return false;

        // exclude current city
        $exclude[] = $current;

        // explore graph
        $possibilities = [];
        foreach($this->_roads[$current] as $place => $value){
            if(!in_array($place, $exclude)) {

                // get data
                $data = $this->pathfinder($place, $to, $road, $exclude, $step + 1 + $value);

                // bad way
                if(!$data)
                    continue;

                // add to possibilities
                $possibilities[$data[1]] = $data;
            }
        }

        // return shortest possibilities
        return empty($possibilities)
            ? false
            : array_shift($possibilities);
    }


    /**
     * Find Location from address
     * @param $search
     * @return \mist\Location
     */
    public function find($search)
    {
        return (isset($this->_places[$search]) and ($this->_places[$search] instanceof Location))
            ? $this->_places[$search]
            : false;
    }


    /**
     * Find path between two points
     * @param $from
     * @param $to
     * @return array
     */
    public function path($from, $to)
    {
        $path = $this->pathfinder($from, $to);
        return $path
            ? $path[0]
            : false;
    }


    /**
     * Display map
     * @param null $search
     * @return string
     */
    public function display($search = null)
    {
        // no map yet
        if(!$this->_mapfile)
            return 'No map implemented.';

        // place requested
        $location = current($this->_places);
        if($place = $this->find($search))
            $location = $place;

        $html = '
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
            <script>
            $(document).ready(function(){
                $("#mistmap img").draggable();
            });
            </script>
            <div id="mistmap" style="width:800px; height:600px; overflow: hidden;">
                <img src="' . $this->_mapfile . '" style="cursor: pointer; position: relative;
                            top: -' . ($location->lng - 300) . 'px; left: -' . ($location->lat - 400) . 'px;" />
            </div>
        ';

        return $html;
    }
}