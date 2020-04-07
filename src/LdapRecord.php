<?php

namespace nohnaimer\ldaprecord;

use yii\base\Component;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\DetailedError;
use LdapRecord\Auth\BindException;
use LdapRecord\ConnectionException;

/**
 * Class LdapRecord
 * @package nohnaimer\ldaprecord
 *
 * @mixin Connection
 */
class LdapRecord extends Component
{
    /**
     * @var array
     */
    public $providers;
    /**
     * @var Connection[]
     */
    protected $connections = [];

    /**
     * @param string $name
     * @return Connection
     * @throws BindException
     * @throws ConnectionException
     */
    public function initProvider($name)
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }

        $config = $this->providers[$name];
        $connection = new Connection($config);
        try {
            $connection->connect();
        } catch (BindException $e) {
            /** @var DetailedError $error */
            $error = $e->getDetailedError();
            throw new BindException("Code: {$error->getErrorCode()}, message: {$error->getErrorMessage()}, diagnostic: {$error->getDiagnosticMessage()}");
        }

        Container::addConnection($connection, $name);
        return $this->connections[$name] = $connection;
    }
}