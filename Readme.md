# Mist

**Mist** est une API de cartographie utilisant *pour le moment* MapQuest


## Installation

Copier le dossier **mist** dans votre projet et enregistrer le namespace **mist** de la librairie.

### Autoloader

Dans le cas où vous ne disposez pas d'autoloader, voici un exemple basique vous permettant de tester **Mist** (à placer à la racine de votre projet) :

```php
function __autoload($classname)
{
    $root = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    require_once $root . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
}
```


## Initialisation

Mist se veut être une librairie abstraite et non liée exclusiement à un seul service, pour se faire, Mist propose une interface permettant à tout service de se plugger dessus.

```php
$api = new mist\api\MapQuest('your_api_key');
$map = new mist\Map($api);
```


## Utilisation

Mist propose 3 services : la recherche de coordonnées, la recherche d'itinéraire et l'affichage de la carte.
Chaque fonction de recherche retournera un ou plusieurs objets **mist\Location** (lat, lng, street, postcode, state, county, country, other)

### Recherche de coordonnées

```php
$city = $map->find('Annecy,FR');
```

### Recherche d'itinéraire

```php
$route = $map->path('Paris,FR', 'Annecy,FR'); // encore instable
```

### Afficher la carte

```php
echo $map; // affichera par défaut : Annecy, FR
```

### Afficher la carte sur un endroit précis

```php
echo $map('Paris,FR');
```


## Extension

### API

Si vous souhaitez créer votre propre API (pour OpenStreetMap par exemple), elle doit obligatoirement implémenter l'interface **mist\API**
et proposer les fonctions suivantes :

```php
interface API
{

    /**
     * @param $search
     * @return \mist\Location
     */
    public function find($search);

    /**
     * @param $from
     * @param $to
     * @return array
     */
    public function path($from, $to);

    /**
     * @param null $search
     * @return string
     */
    public function display($search = null);

}
```

### Kit

**Mist** vous propose un class *Kit* vous permettant de créer vos propres cartes sous forme de graphe.
Prenons l'exemple de *SpiraMap* inclut dans **Mist**, tout se passe dans la méthode **setup** :

```php
use mist\Kit;

class SpiraMap extends Kit
{
    protected function setup()
    {
        // tout se passe ici
    }
}
```

La création du graphe se déroule en 3 étapes, d'abord définir le fichier image représentant la carte :

```php
$this->_mapfile = 'api/SpiraMap.png';
```

Ensuite la création des villes et endroits (les coordonnées sont en pixels par rapport à la position sur l'image) :

```php
$this->place('Besaid', [926, 2075])
     ->place('Kilika', [1020, 2000])
     ->place('Luca', [1040, 1850]));
```

Pour finir, la définition des chemins entres les endroits :

```php
$this->road('Besaid', 'Kilika')
     ->road('Kilika', 'Luca');
```

Ce kit implémente automatiquement les méthodes de parcours et de recherche en fonction du graph que vous avez créé.
Il vous suffit alors d'appeler cet API comme MapQuest :

```php
$api = new mist\api\SpiraMap();
$map = new mist\Map($api);
```


## A venir :

 * Options d'affichage de la carte
 * Granularité de recherche