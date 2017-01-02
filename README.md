[![Build Status](https://scrutinizer-ci.com/g/jbcrestot/NavitiaPhp/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jbcrestot/NavitiaPhp/build-status/master)

# Navitia PHP client

PHP client for Navitia API (http://navitia.io).


## Installation

Requires PHP 5.4 or +

Add in your composer:

``` json
{
    "require": {
        "canaltp/navitiaphp": "~1.0"
    }
}
```

Then `composer update`.


## Usage

Instanciation and call your first Api endpoint (i.e `coverage`):

``` php
require_once 'vendor/autoload.php';

use CanalTP\NavitiaPhp\Navitia;

$navitia = Navitia::createFromBaseUrlAndToken('http://api.navitia.io/v1/', '3b036afe-0110-4202-b9ed-99718476c2e0');

$result = $navitia->call('coverage/sandbox');
/*
Returns:

stdClass Object
(
    [regions] => Array
        (
            [0] => stdClass Object
                (
                    [id] => sandbox
                    ...
                )
        )
    [links] => Array
        (
            ...
        )
)
```


Using QueryBuilder:

``` php
require_once 'vendor/autoload.php';

use CanalTP\NavitiaPhp\Navitia;
use CanalTP\NavitiaPhp\QueryBuilder;

$navitia = Navitia::createFromBaseUrlAndToken('http://api.navitia.io/v1/', '3b036afe-0110-4202-b9ed-99718476c2e0');

$queryBuilder = new QueryBuilder();

$query = $queryBuilder
    ->path('traffic_reports')
    ->coverage('fr-idf')
    ->param('datetime', '20160615T1337')
    ->getQuery()
;

$result = $navitia->call($query); // Calls 'coverage/fr-idf/traffic_reports'
```

Using single navitia instance:
``` php
$navitia = new Navitia($myClient, 'myDefaultCoverage');

$query = $navitia->createQueryBuilder()
    ->path('traffic_reports')
    ->param('datetime', '20160615T1337')
    ->getQuery();
    
$result = $navitia->call($query);
```


## Testing

Running tests:

``` bash
vendor/bin/phpunit -c .
```

## Checking code style:
 
``` bash
vendor/bin/phpcs src --standard=phpcs.xml
```
 

## License

This project is under [MIT](LICENSE) license.
