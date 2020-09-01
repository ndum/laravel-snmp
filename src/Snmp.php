<?php

namespace Ndum\Laravel;

use Exception;
use FreeDSx\Snmp\SnmpClient;
use FreeDSx\Snmp\Requests;

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
     */
    public function __construct()
    {
        try {
            $this->instance = new SnmpClient();
        } catch (Exception $e) {
            throw new Exception('Error initializing FreeDSx/Snmp', 1);
        }
    }

    /**
     * @param string $host
     * @param int $version
     * @param string $community
     * @param int $port
     * @param string $transport
     * @param null $user
     * @param bool $auth
     * @param null $auth_mech
     * @param null $auth_pwd
     * @param bool $use_priv
     * @param null $priv_mech
     * @param null $priv_pwd
     * @return SnmpClient
     */
    public function newClient($host, $version, $community, $port = 161, $transport = 'udp', $user = null, $auth = false,
        $auth_mech = null, $auth_pwd = null, $use_priv = false, $priv_mech = null, $priv_pwd = null)
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
            'priv_pwd' => $priv_pwd
        ]);
    }

    /**
     * @param array $oidList
     * @return \FreeDSx\Snmp\OidList
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function get($oidList)
    {
        return $this->client->get($oidList);
    }

    /**
     * @param string $value
     * @return string
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function getValue($value)
    {
        return $this->client->getValue($value);
    }

    /**
     * @param string $oid
     * @return \FreeDSx\Snmp\Oid|null
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function getOid($oid)
    {
        return $this->client->getOid($oid);
    }

    /**
     * @return \FreeDSx\Snmp\SnmpWalk
     */
    public function walk()
    {
        return $this->client->walk();
    }

    /**
     * @param string $oids
     * @return \FreeDSx\Snmp\Message\Response\MessageResponseInterface|null
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function setOids($oids)
    {
        return $this->client->set($oids);
    }

    /**
     * @param $request
     * @return \FreeDSx\Snmp\Message\Response\MessageResponseInterface|null
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function send($request)
    {
        return $this->client->send($request);
    }

    /**
     * @param $oids
     * @return \FreeDSx\Snmp\OidList
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function getNext($oids)
    {
        return $this->client->getNext($oids);
    }

    /**
     * @param $reps
     * @param $nonRepeater
     * @param $oid
     * @return \FreeDSx\Snmp\OidList
     * @throws \FreeDSx\Snmp\Exception\ConnectionException
     * @throws \FreeDSx\Snmp\Exception\SnmpRequestException
     */
    public function getBulk($reps, $nonRepeater, $oid)
    {
        return $this->client->getBulk($reps, $nonRepeater, $oid);
    }

    /**
     * @return Requests
     */
    public function request()
    {
        return new Requests;
    }
}
