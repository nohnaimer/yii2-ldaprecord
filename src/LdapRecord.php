<?php

namespace nohnaimer\ldaprecord;

use yii\base\Component;
use LdapRecord\Connection;
use LdapRecord\DetailedError;
use LdapRecord\Auth\BindException;
use LdapRecord\Configuration\ConfigurationException;

/**
 * Class LdapRecord
 * @package nohnaimer\ldaprecord
 */
class LdapRecord extends Component
{
    /**
     * @var array
     */
    public $settings;
    /**
     * @var Connection
     */
    private $_connection;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (is_array($this->settings)) {
            $this->_connection = new Connection($this->settings);
            try {
                $this->_connection->connect();
            } catch (BindException $e) {
                /** @var DetailedError $error */
                $error = $e->getDetailedError();
                throw new BindException("Code: {$error->getErrorCode()}, message: {$error->getErrorMessage()}, diagnostic: {$error->getDiagnosticMessage()}");
            }
        }

        throw new ConfigurationException('Configuration options could not be found.');
    }
}