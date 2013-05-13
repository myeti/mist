<?php

namespace mist\api;

use mist\Kit;

class SpiraMap extends Kit
{

    /**
     * Setup cities and roads
     */
    protected function setup()
    {
        // map file
        $this->_mapfile = 'api/SpiraMap.png';

        // places
        $this->place('Besaid', [926, 2075])
             ->place('Kilika', [1020, 2000])
             ->place('Luca', [1040, 1850])
             ->place('Route de Mi\'hen', [990, 1722])
             ->place('Route des Mycorocs', [1114, 1659])
             ->place('Djose', [1217, 1609])
             ->place('Sélénos', [1300, 1425])
             ->place('Guadosalam', [1212, 1286])
             ->place('Plaine foudroyée', [1300, 1193])
             ->place('Forêt de Macalania', [1238, 1068])
             ->place('Lac de Macalania', [1126, 1007])
             ->place('Bevelle', [1044, 914])
             ->place('Plaine Félicité', [1012, 813])
             ->place('Temple de Remiem', [1189, 785])
             ->place('Grotte du priant volé', [1080, 681])
             ->place('Mont Gagazet', [1077, 526])
             ->place('Zanarkand', [1191, 420])
             ->place('Desert de Bikanel', [531, 1248])
             ->place('Temple de Baaj', [501, 1637])
             ->place('Ruines d\'Omega', [1865, 1089]);

        // roads @todo
        $this->road('Besaid', 'Kilika')
             ->road('Kilika', 'Luca');
    }
}