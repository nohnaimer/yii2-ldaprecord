Yii2 LdapRecord extension
====================
[Documentation](https://ldaprecord.com/docs/) for LdapRecord

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

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
'ldap' => [
            'class' => nohnaimer\ldaprecord\LdapRecord::class,
            'providers' => [
                'ad' => [
                    'class' => nohnaimer\ldaprecord\LdapRecord::class,
                     // Mandatory Configuration Options
                     'hosts'            => ['192.168.1.1'],
                     'base_dn'          => 'dc=local,dc=com',
                     'username'         => 'admin@local.com',
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
                     ],
                ],
                'ldap' => [
                    'hosts' => ['192.168.1.2'],
                    'base_dn' => 'dc=local,dc=com',
                    'username' => 'cn=admin,dc=mts,dc=by',
                    'password' => 'password',

                    // Optional Configuration Options
                    'port' => 389,
                    'version' => 3,

                    // Custom LDAP Options
                    'options' => [
                        // See: http://php.net/ldap_set_option
                        LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD
                    ],
                ],
            ],
        ],
...
],
```
Usage
-----
Simple usage without a user model

Query:
```php
Yii::$app->ldap->initProvider('ad')->query()->where('cn', '=', 'John Doe')->get();
```
Authentication:
```php
Yii::$app->ldap->initProvider('ad')->auth()->attempt('username', 'password', true);
```

Simple usage with a model

Model:
```php
class User extends \LdapRecord\Models\ActiveDirectory\User
{
    /**
     * The "booting" method of the model.
     * @throws \LdapRecord\Auth\BindException
     * @throws \LdapRecord\ConnectionException
     */
    protected static function boot()
    {
        Yii::$app->ldap->initProvider('ad');
    }

    protected $connection = 'ad';
}
```

```php
$user = User::findByGuid('guid');
```