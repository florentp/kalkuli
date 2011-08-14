<?php

	require_once(PEAR_INCLUDE_PREFIX . 'Mail.php');

	class MailerFactory {
		public static function createNewInstance() {
			return Mail::factory(
				'smtp',
				array (
					'host' => SMTP_HOST,
					'port' => SMTP_PORT,
					'auth' => SMTP_USE_AUTH,
					'username' => SMTP_USERNAME,
					'password' => SMTP_PASSWORD)
			);
		}

	}