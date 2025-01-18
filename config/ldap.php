<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default LDAP Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the LDAP connections below you wish
	| to use as your default connection for all LDAP operations. Of
	| course you may add as many connections you'd like below.
	|
	*/

	'default' => env('LDAP_CONNECTION', 'default'),

	/*
	|--------------------------------------------------------------------------
	| LDAP Connections
	|--------------------------------------------------------------------------
	|
	| Below you may configure each LDAP connection your application requires
	| access to. Be sure to include a valid base DN - otherwise you may
	| not receive any results when performing LDAP search operations.
	|
	*/

	'connections' => [

		'default' => [
			'hosts' => [env('LDAP_HOST', '127.0.0.1')],
			'username' => env('LDAP_USERNAME', 'cn=user,dc=local,dc=com'),
			'password' => env('LDAP_PASSWORD', 'secret'),
			'port' => env('LDAP_PORT', 389),
			'base_dn' => env('LDAP_BASE_DN', 'dc=local,dc=com'),
			'timeout' => env('LDAP_TIMEOUT', 5),
			'use_ssl' => env('LDAP_SSL', false),
			'use_tls' => env('LDAP_TLS', false),
			'name' => env('LDAP_NAME','LDAP Server'),
		],

	],

	/*
	|--------------------------------------------------------------------------
	| LDAP Logging
	|--------------------------------------------------------------------------
	|
	| When LDAP logging is enabled, all LDAP search and authentication
	| operations are logged using the default application logging
	| driver. This can assist in debugging issues and more.
	|
	*/

	'logging' => env('LDAP_LOGGING', true),

	/*
	|--------------------------------------------------------------------------
	| LDAP Cache
	|--------------------------------------------------------------------------
	|
	| LDAP caching enables the ability of caching search results using the
	| query builder. This is great for running expensive operations that
	| may take many seconds to complete, such as a pagination request.
	|
	*/

	'cache' => [
		'enabled' => env('LDAP_CACHE', false),
		'driver' => env('CACHE_DRIVER', 'file'),
		'time' => env('LDAP_CACHE_TIME',5*60),		// Seconds
	],

	/*
	 |--------------------------------------------------------------------------
	 | Support for attrs display order
	 |--------------------------------------------------------------------------
	 |
	 | Use this array if you want to have your attributes displayed in a specific
	 | order. Case is not important.
	 |
	 | For example, "sn" will be displayed right after "givenName". All the other
	 | attributes that are not specified in this array will be displayed after in
	 | alphabetical order.
	 |
	 */

	'attr_display_order' => [],
	/*
	'attr_display_order' => [
		'givenName',
		'sn',
		'cn',
		'displayName',
		'uid',
		'uidNumber',
		'gidNumber',
		'homeDirectory',
		'mail',
		'userPassword'
	],
	*/

	/*
	 * If 'login,attr' is used above such that phpLDAPadmin will search for your DN
	 * at login, you may restrict the search to a specific objectClasses. EG, set this
	 * to array('posixAccount') or array('inetOrgPerson',..), depending upon your
	 * setup.
	 */
	'login' => [
		'attr' => [env('LDAP_LOGIN_ATTR','uid') => env('LDAP_LOGIN_ATTR_DESC','User ID')],	// Attribute used to find user for login
		'objectclass' => explode(',',env('LDAP_LOGIN_OBJECTCLASS', 'posixAccount')),		// Objectclass that users must contain to login
	],

	/*
	 |--------------------------------------------------------------------------
	 | Custom Date Format
	 |--------------------------------------------------------------------------
	 |
	 | Configuration to determine how date fields will be displayed.
	 |
	 */
	'datetime_format' => 'Y-m-d H:i:s',

	/*
	 |--------------------------------------------------------------------------
	 | Validation
	 |--------------------------------------------------------------------------
	 |
	 | Default validation used for data input.
	 |
	 */
	'validation' => [
		'objectclass' => [
			'objectclass'=>[
				'array',
				'min:1'
			]
		],
		'gidnumber' => [
			'gidnumber'=> [
				'sometimes',
				'array',
				'max:1'
			],
			'gidnumber.*' => [
				'nullable',
				'integer',
				'max:65535'
			]
		],
		'mail' => [
			'mail'=>[
				'sometimes',
				'array',
				'min:1'
			],
			'mail.*' => [
				'nullable',
				'email'
			]
		],
		'userpassword' => [
			'userpassword' => [
				'sometimes',
				'array',
				'min:1'
			],
			'userpassword.*' => [
				'nullable',
				'min:8'
			]
		],
		'uidnumber' => [
			'uidnumber' => [
				'sometimes',
				'array',
				'max:1'
			],
			'uidnumber.*' => [
				'nullable',
				'integer',
				'max:65535'
			]
		],
	],
];
