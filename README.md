# laravel-snmp

This Laravel-Package provides an simple Laravel-Wrapper for the excellent FreeDSx/SNMP class.

## Requirements

Requires: Laravel >= 5.5 or Laravel 6.x / 7.x / 8.x and PHP 7.1 or higher

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

##### SNMP trap sink (Trap Listener/Server):
1) First, create a trap listener-class (examples can be found [here](https://github.com/ndum/laravel-snmp/tree/master/examples)
2) Then use it like the following example:

```php
use Ndum\Laravel\SnmpTrapServer; # don't forget to use your listener also!

# default options
$options = [
        'ip' => '0.0.0.0',
        'port' => 162,
        'transport' => 'udp',
        'version' => null,
        'community' => null,
        'whitelist' => null,
        'timeout_connect' => 5,
    ];

$listener = new TrapListener(); ### your in step 1 created listener-class
$server = new SnmpTrapServer($listener, $options) # $options only needed if other than default;
$server->listen();

# in addition: (only if needed)
$server->getOptions(); # to get the options
$server->setOptions($options); # to set the options
```
The official documentation for trap sink can be found [here](https://github.com/FreeDSx/SNMP/blob/master/docs/Server/Trap-Sink.md)

## Limitations
SNMP trap sink currently does not support SNMPv3 inform requests. However, SNMPv2 inform requests are supported.

## Issues / Contributions
Directly via GitHub

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
