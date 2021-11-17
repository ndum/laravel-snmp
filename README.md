# laravel-snmp

This Laravel-Package provides an simple SNMP-Wrapper for FreeDSx/SNMP class.

A refactored version is in planning the next weeks. (Nov. 2021) This version will provide more options and SNMP traps support.

## Requirements

Requires: [FreeDSx/SNMP](https://github.com/FreeDSx/SNMP) and Laravel >= 5.5 or Laravel 6.x / 7.x / 8.x

## Installation
Install via Composer.

```bash
$ composer require ndum/laravel-snmp
```

## Documentation

The official documentation can be found [here](https://github.com/FreeDSx/SNMP#documentation)

## Examples

##### Traditionally:

```php
use Ndum\Laravel\Snmp;

$snmp = new Snmp();
$snmp->newClient('servername', 2, 'secret');
$result = $snmp->getValue('1.3.6.1.2.1.1.5.0'); ## hostname
dd($result);
```

##### Facade:
```php
use Ndum\Laravel\Facades\Snmp;

$snmp = Snmp::newClient('servername', 2, 'secret');
$result = $snmp->getValue('1.3.6.1.2.1.1.5.0'); ## hostname
dd($result);
```
## Extras

##### Timeout-Settings:
```php
use Ndum\Laravel\Snmp;

$snmp = new Snmp();
$snmp->newClient('servername', 2, 'secret');
$snmp->setTimeoutConnectValue(5); # set a value for timeout_connect
$snmp->setTimeoutReadValue(10); # set a value for timeout_read

$result = $snmp->getValue('1.3.6.1.2.1.1.5.0'); ## hostname
dd($result);
```

## Limitations
SNMP traps are not yet supported in the current version. (Coming Soon!)

## Issues / Contributions

Directly via GitHub

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
