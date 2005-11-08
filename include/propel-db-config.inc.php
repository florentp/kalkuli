<?php

	return array (
			'log' => array (
					'ident' => 'money',
					'level' => PROPEL_DEBUG_LEVEL,
				),
			'propel' => array (
					'datasources' => array (
							'money' => array (
									'adapter' => 'sqlite',
									'connection' => array (
											'phptype' => 'sqlite',
											'hostspec' => 'localhost',
											'database' => DATABASE_PATH,
											'username' => '',
											'password' => '',
									),
							),
							'default' => 'money',
					),
			),
	);