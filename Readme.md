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
echo $map;
```

### Afficher la carte sur un endroit précis

```php
echo $map('Paris,FR');
```


## Extension

Si vous osuhaitez créer votre propre API (pour OpenStreetMap par exemple), elle doit obligatoirement implémenter l'interface **mist\API**
et propose les fonctions suivantes :

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


## A venir :

 * Options d'affichage
 * Granularité de recherche