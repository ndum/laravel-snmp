<?php

namespace Ndum\Laravel;

use Exception;
use FreeDSx\Snmp\Exception\ConnectionException;
use FreeDSx\Snmp\Exception\SnmpRequestException;
use FreeDSx\Snmp\Message\Response\MessageResponseInterface;
use FreeDSx\Snmp\Oid;
use FreeDSx\Snmp\OidList;
use FreeDSx\Snmp\Requests;
use FreeDSx\Snmp\SnmpClient;
use FreeDSx\Snmp\SnmpWalk;

class Snmp
{
    /**
     * @var SnmpClient
     */
    protected $instance;

    /**
     * @var SnmpClient
     */
    protected $client;

    /**
     * Snmp constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->instance = new SnmpClient();
        } catch (Exception $e) {
            throw new \RuntimeException('Error initializing FreeDSx/Snmp', 1);
        }
    }

    /**
     * @param null $user
     * @param null $auth_mech
     * @param null $auth_pwd
     * @param null $priv_mech
     * @param null $priv_pwd
     */
    public function newClient(string $host, int $version, string $community, int $port = 161, string $transport = 'udp',
                              $user = null, bool $auth = false, $auth_mech = null, $auth_pwd = null, bool $use_priv = false,
                              $priv_mech = null, $priv_pwd = null): SnmpClient
    {
        return $this->client = new SnmpClient([
            'host' => $host,
            'version' => $version,
            'community' => $community,
            'port' => $port,
            'transport' => $transport,
            'user' => $user,
            'use_auth' => $auth,
            'auth_mech' => $auth_mech,
            'auth_pwd' => $auth_pwd,
            'use_priv' => $use_priv,
            'priv_mech' => $priv_mech,
            'priv_pwd' => $priv_pwd,
        ]);
    }

    /**
     * @param int $timeout
     * @return void
     */
    public function setTimeoutConnectValue(int $timeout = 5): void
    {
        $options = $this->getOptions();

        $options['timeout_connect'] = $timeout;

        $this->setOptions($options);
    }

    /**
     * @param int $timeout
     * @return void
     */
    public function setTimeoutReadValue(int $timeout = 10): void
    {
        $options = $this->getOptions();

        $options['timeout_read'] = $timeout;

        $this->setOptions($options);
    }

    /**
     * @param $oidList
     * @return OidList
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function get($oidList): OidList
    {
        return $this->client->get($oidList);
    }

    /**
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function getValue(string $value): string
    {
        return $this->client->getValue($value);
    }

    /**
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function getOid(string $oid): ?Oid
    {
        return $this->client->getOid($oid);
    }

    public function walk(): SnmpWalk
    {
        return $this->client->walk();
    }

    /**
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function setOids(Oid $oids): ?MessageResponseInterface
    {
        return $this->client->set($oids);
    }

    /**
     * @param $request
     * @return MessageResponseInterface|null
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function send($request): ?MessageResponseInterface
    {
        return $this->client->send($request);
    }

    /**
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function getNext(Oid $oids): OidList
    {
        return $this->client->getNext($oids);
    }

    /**
     * @param $reps
     * @param $nonRepeater
     * @param Oid $oid
     * @return OidList
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function getBulk($reps, $nonRepeater, Oid $oid): OidList
    {
        return $this->client->getBulk($reps, $nonRepeater, $oid);
    }

    /**
     * @return Requests
     */
    public function request(): Requests
    {
        return new Requests();
    }

    /**
     * @param string $enterprise
     * @param string $address
     * @param int $genericType
     * @param int $specificType
     * @param int $sysUpTime
     * @param ...$oids
     * @return $this
     */
    public function sendTrapV1(string $enterprise, string $address, int $genericType, int $specificType, int $sysUpTime, ...$oids)
    {
        $oidsTicks = Oid::fromTimeticks(...$oids);

        $this->send(Requests::trapV1($enterprise, $address, $genericType, $specificType, $sysUpTime, $oidsTicks));

        return $this;
    }

    /**
     * @param $sysUpTime
     * @param $trapOid
     * @param ...$oids
     * @return $this
     * @throws ConnectionException
     * @throws SnmpRequestException
     */
    public function sendTrap($sysUpTime, $trapOid, ...$oids)
    {
        $oidsTicks = Oid::fromTimeticks(...$oids);

        $this->send(Requests::trap($sysUpTime, $trapOid, $oidsTicks));

        return $this;
    }

    /**
     * @param $sysUpTime
     * @param $trapOid
     * @param ...$oids
     * @return MessageResponseInterface
     */
    public function sendInform($sysUpTime, $trapOid, ...$oids): MessageResponseInterface
    {
        $oidsTicks = Oid::fromTimeticks(...$oids);

        return $this->sendAndReceive(Requests::inform($sysUpTime, $trapOid, $oidsTicks));
    }

    /**
     * @return array
     */
    private function getOptions(): array
    {
        return $this->client->getOptions();
    }

    /**
     * @param $options
     */
    private function setOptions($options): void
    {
        $this->client->setOptions($options);
    }
}
