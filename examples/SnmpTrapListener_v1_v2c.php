<?php

namespace Ndum\Laravel; //# change it!

use FreeDSx\Snmp\Message\EngineId;
use FreeDSx\Snmp\Module\SecurityModel\Usm\UsmUser;
use FreeDSx\Snmp\Trap\TrapContext;
use FreeDSx\Snmp\Trap\TrapListenerInterface;

class SnmpTrapListener_v1_v2c implements TrapListenerInterface
{
    /**
     * @param string $ip
     * @return bool
     */
    public function accept(string $ip): bool
    {
        return true;
    }

    /**
     * @param EngineId $engineId
     * @param string $ipAddress
     * @param string $user
     * @return UsmUser|null
     */
    public function getUsmUser(EngineId $engineId, string $ipAddress, string $user): ?UsmUser
    {
        // can be empty
    }

    /**
     * @param TrapContext $context
     * @return void
     */
    public function receive(TrapContext $context): void
    {
        // The full SNMP message
        $message = $context->getMessage();
        // The IP address the trap came from
        $ipAddress = $context->getIpAddress();
        // The trap request object only
        $trap = $context->getTrap();
        // The SNMP version that was used
        $version = $context->getVersion();

        //# examples:

        // -> dd($context);;
        // -> Log::alert($message);
        // -> TBD::someClass($context);
        //
        // or whatever u want ;) don't forget, it's a listener!
        //
    }
}
