LdapRecord extension
====================
Расширение для библиотеки LdapRecord

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nohnaimer/yii2-ldaprecord "*"
```

or add

```
"nohnaimer/yii2-ldaprecord": "*"
```

to the require section of your `composer.json` file.


Configuration
-----

```php
'components' => [
...
        'ad' => [
            'class' => nohnaimer\ldaprecord\LdapRecord::class,
            // Mandatory Configuration Options
            'hosts'            => ['192.168.1.1'],
            'base_dn'          => 'dc=local,dc=com',
            'username'         => 'cn=admin,dc=local,dc=com',
            'password'         => 'password',
            
            // Optional Configuration Options
            'port'             => 389,
            'follow_referrals' => false,
            'use_ssl'          => false,
            'use_tls'          => false,
            'version'          => 3,
            'timeout'          => 5,
            
            // Custom LDAP Options
            'options' => [
                // See: http://php.net/ldap_set_option
                LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD
            ]
        ],
...
],
```