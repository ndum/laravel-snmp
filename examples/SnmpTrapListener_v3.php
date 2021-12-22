<?php

namespace Ndum\Laravel; //# change it!

use FreeDSx\Snmp\Message\EngineId;
use FreeDSx\Snmp\Module\SecurityModel\Usm\UsmUser;
use FreeDSx\Snmp\Trap\TrapContext;
use FreeDSx\Snmp\Trap\TrapListenerInterface;

class SnmpTrapListener_v3 implements TrapListenerInterface
{
    /**
     * @var array
     */
    protected $users = [];

    /**
     * constructor.
     */
    public function __construct()
    {
        $user1 = UsmUser::withPrivacy('user1', 'auth-password123', 'sha512', 'priv-password123', 'aes128');

        $this->users[EngineId::fromText('foobar123')->toBinary()]['user1'] = $user1;
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function accept(string $ip): bool
    {
        // Implement any logic here for IP addresses you want to accept / decline...
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
        // Assuming we have an array populated with the engine and users associated with it...
        return $this->users[$engineId->toBinary()][$user] ?? null;
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
