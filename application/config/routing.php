<?php defined('CONFIGURATION_LOADED') OR die('No direct script access.');

/**
 * HOW TO USE:
 * config::get(routing.property_name, $default_value);
 */
return [
	'cache' => [
		'connection' => 'default',
		'timeout' => '00:00:10',
		'key' => 'REST_API_ROUTING' . md5(__DIR__),
	],
];