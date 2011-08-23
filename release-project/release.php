<?php
/*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.ku.'li/.
 * 
 * /kal.ku.'li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.ku.'li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.ku.'li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

$version = readline("New version number: ");

echo 'Moving to root directory ... ';
chdir(dirname(__FILE__));
chdir('..');
echo getcwd() . "\n";

echo 'Cleaning target directory ... ';
if (is_dir('target'))
	rm('target');
echo "Done\n";

echo 'Creating target directory ... ';
mkdir('target');
echo "Done\n";

echo 'Creating kalkuli archive ... ';

$archiveFilename = sprintf('target/kalkuli-%s.zip', $version);
$zip = new CustZipArchive();
$zip->open($archiveFilename, ZIPARCHIVE::CREATE);

$excludeFileset = array(
		'kalkuli/.buildpath',
		'kalkuli/.htaccess',
		'kalkuli/.project',
		'kalkuli/.settings',
		'kalkuli/include/config.inc.php',
		'kalkuli/templates_c',
		'kalkuli/propel-project'
	);
$zip->addDir('kalkuli', $excludeFileset);
$zip->addEmptyDir('kalkuli/templates_c');
$zip->addFromString('kalkuli/include/VERSION', $version);

$zip->close();

echo $archiveFilename . "\n";

function startsWith($haystack, $needle) {
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
	$length = strlen($needle);
	$start  = $length * -1; //negative
	return (substr($haystack, $start) === $needle);
}

function rm($path) {
	if (is_dir($path)) {
		if ($dh = opendir($path)) {
				
			while (($sub = readdir($dh)) !== false)
				if (($sub != '.') && ($sub != '..'))
					if (is_dir ($path . '/' . $sub))
						rm($path . '/' . $sub);
					else
						unlink ($path . '/' . $sub);
					
			closedir($dh);
		}

		rmdir($path);
	}
	else
		unlink($path);
}

class CustZipArchive extends ZipArchive {
	public function addDir($path, $excludeFileset) {
		$this->addEmptyDir($path);
		$nodes = glob("$path/{,.}*", GLOB_BRACE);
		
		foreach ($nodes as $node) {
			if (!endsWith($node, '/.')
					&& !endsWith($node, '/..')
					&& !in_array($node, $excludeFileset)) {
				
				if (is_dir($node)) {
					$this->addDir($node, $excludeFileset);
				}
				else if (is_file($node)) {
					$this->addFile($node);
				}
			}
		}
	}
}
