<?php

/*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.'ku.li/.
 * 
 * /kal.'ku.li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.'ku.li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.'ku.li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

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
