<?php

namespace Ndum\Laravel;

use FreeDSx\Snmp\Exception\ConnectionException;
use FreeDSx\Snmp\Protocol\TrapProtocolHandler;
use FreeDSx\Snmp\Server\ServerRunner\ServerRunnerInterface;
use FreeDSx\Snmp\Server\ServerRunner\TrapServerRunner;
use FreeDSx\Snmp\Trap\TrapListenerInterface;
use FreeDSx\Socket\SocketServer;

class SnmpTrapServer
{
    /**
     * @var array
     */
    protected $options = [
        'ip' => '0.0.0.0',
        'port' => 162,
        'transport' => 'udp',
        'version' => null,
        'community' => null,
        'whitelist' => null,
        'timeout_connect' => 5,
    ];

    /**
     * @var TrapServerRunner
     */
    protected $server;

    /**
     * @var TrapListenerInterface
     */
    protected $listener;

    /**
     * @param TrapListenerInterface $listener
     * @param array $options
     */
    public function __construct(TrapListenerInterface $listener, array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $this->listener = $listener;
    }

    /**
     * Start listening for traps.
     *
     * @throws ConnectionException
     */
    public function listen(): void
    {
        try {
            $this->server()->run(SocketServer::bindUdp($this->options['ip'], $this->options['port']));
        } catch (\FreeDSx\Socket\Exception\ConnectionException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return $this
     */
    public function setOptions(array $options): SnmpTrapServer
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @return $this
     */
    public function setServer(TrapServerRunner $server): SnmpTrapServer
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return ServerRunnerInterface
     */
    protected function server(): ServerRunnerInterface
    {
        return $this->server = new TrapServerRunner(new TrapProtocolHandler($this->listener, $this->options), $this->options);
    }
}
