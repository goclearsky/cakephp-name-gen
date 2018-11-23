# NameGen plugin for CakePHP

A plugin to generate random names as can be needed during development.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

```
composer require goclearsky/name-gen
```
## Use

The Generator class defines the getNames function.
```
static function getNames($size, $gender = null, $locale = null, $cardinality = 2)
```
Size is the number of people's names you are requesting. Gender is a single character.
Locale is in the form of the typical locale values. Currently available are en_US.
The last parameter indicates the cardinality of each name generated. If middle names
are desired, then use 3, otherwise 2 provides given and family names only.
```
cardinality == 3 ---> Amy Abigail Adams
cardinality == 2 ---> Amy Adams
```
If cardinality is 3, each name is checked to ensure the given and middle names are
different.
Irrespective of cardinality, the set is checked to ensure each name is unique.

Typical use might be to create a shell that requests a set of names using getNames,
then saves them to your database tables as needed. Could also be used to quickly
generate test source data.
```php
namespace App\Shell;

use ClearSky\NameGen\Utility\Generator;

class DevShell extends Shell
{

    public static function name()
    {
        $names = Generator::getNames(3, 'F');

        $query = TableRegistry::get('Users')->query();
        $query->insert(['first_name', 'last_name']);
        foreach ($names as $name) {
            $query->values([
                'first_name' => $name['given'],
                'last_name' => $name['family'],
            ]);
        }
        $query->execute();

        print_r($names);
    }

}
```

The above shell generates the following output and saves these names in the users table;

```php
miket@dev:~/workspace/myapp $ cake dev name
Array
(
    [0] => Array
        (
            [given] => Amy
            [family] => Jones
        )

    [1] => Array
        (
            [given] => Laura
            [family] => Brooks
        )

    [2] => Array
        (
            [given] => Sara
            [family] => Morgan
        )

)
miket@dev:~/workspace/myapp $ 
```

## Contributing

All suggestions and feedback are welcome. One thing that could help the general appeal of the
plugin is to have more seeds for different countries.

## Limitations / ToDo's

Add exception handling. The algorithm isn't exhaustive. It is possible to; a) request more names
than are possible to uniquely provide based on the size of the pool to pull from, and b) request
more names than are reasonable to return by simply randomly picking a name and checking for
uniqueness. Because of this, ```getNames()``` can actually return a result set smaller than the number
requested. If this is important, either check the set size upon return, or reduce the requested
size in relation to the pool size. As it is, 5000 names can be generated in less than 1 second on
2012 hardware.