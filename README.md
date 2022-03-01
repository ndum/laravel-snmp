# laravel-snmp

This Laravel-Package provides an simple Laravel-Wrapper for the excellent FreeDSx/SNMP class.

## Requirements

Requires: Laravel >= 5.5 or higher

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

##### SNMP traps part 1. (sending traps):

***v1***

```php

$snmp = new Snmp();
$snmp->newClient('targetserver', 1, 'secret', 162); 

# Parameters:
# The enterprise OID to trigger (string)
# The IP address. (string)
# The generic trap type (int)
# The specific trap type (int)
# The system uptime (in seconds/int)
# The OIDs and their values (string/int)
$snmp->sendTrapV1('1.3.6.1.4.1.2021.251.1','localhost', 0, 0, 60, '1.3.6.1.2.1.1.3', 60);
```

***v2c / v3***

```php
use Ndum\Laravel\Snmp;

$snmp = new Snmp();
$snmp->newClient('targetserver', 2, 'secret', 162);

# Parameters:
# The system uptime (in seconds/int)
# The trap OID (string)
# The OIDs and their values (string/int)
$snmp->sendTrap(60, '1.3.6.1.4.1.2021.251.1', '1.3.6.1.2.1.1.3', 60));
```

***inform-request (same as v2c / v3 but require a response from target)***

```php
use Ndum\Laravel\Snmp;

$snmp = new Snmp();
$snmp->newClient('targetserver', 2, 'secret', 162);

# Parameters:
# The system uptime (in seconds/int)
# The trap OID (string)
# The OIDs and their values (string/int)
$snmp->sendInform(60, '1.3.6.1.4.1.2021.251.1', '1.3.6.1.2.1.1.3', 60));
```

##### SNMP traps part 2. (Receiving traps / trap sink):
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

$server = new SnmpTrapServer()
$server->prepare($listener, $options) # $options only needed if other than default
$server->listen();

# in addition: (only if needed)
$server->getOptions(); # to get the options
$server->setOptions($options); # to set the options
```
The official documentation for trap sink can be found [here](https://github.com/FreeDSx/SNMP/blob/master/docs/Server/Trap-Sink.md)

## Issues / Contributions
Directly via GitHub

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
