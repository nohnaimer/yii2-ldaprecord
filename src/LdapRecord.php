<?php

namespace nohnaimer\ldaprecord;

use yii\base\Component;
use LdapRecord\Connection;
use LdapRecord\DetailedError;
use LdapRecord\Auth\BindException;

/**
 * Class LdapRecord
 * @package nohnaimer\ldaprecord
 *
 * @mixin Connection
 */
class LdapRecord extends Component
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        $this->connection = new Connection($config);
        try {
            $this->connection->connect();
        } catch (BindException $e) {
            /** @var DetailedError $error */
            $error = $e->getDetailedError();
            throw new BindException("Code: {$error->getErrorCode()}, message: {$error->getErrorMessage()}, diagnostic: {$error->getDiagnosticMessage()}");
        }

        parent::__construct();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->connection->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->connection->$name = $value;
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function __call($name, $params)
    {
        return call_user_func_array([$this->connection, $name], $params);
    }
}