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
     */
    public function setTimeoutConnectValue(int $timeout = 5): void
    {
        $options = $this->getOptions();

        $options['timeout_connect'] = $timeout;

        $this->setOptions($options);
    }

    /**
     * @param int $timeout
     */
    public function setTimeoutReadValue(int $timeout = 10): void
    {
        $options = $this->getOptions();

        $options['timeout_read'] = $timeout;

        $this->setOptions($options);
    }

    /**
     * @param $oidList
     *
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

    /**
     * @return SnmpWalk
     */
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
     *
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
