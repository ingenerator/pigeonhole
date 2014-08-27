<?php
/**
 * Dependency container configuration for pigeonhole, to use 
 * with https://github.com/zeelot/kohana-dependencies
 */
return array(
	'pigeonhole' => array(
		'_settings' => array(
			'class'       => 'Ingenerator\Pigeonhole\Pigeonhole',
			'arguments'   => array('%session%'),
			'shared'      => TRUE,
		),
	),
	'session' => array(
		'_settings' => array(
			'class'       => 'Session',
			'constructor' => 'instance',
			'arguments'   => array(),
			'shared'      => TRUE,
		),
	),
);