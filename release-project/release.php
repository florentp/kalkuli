<?php

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
		'.buildpath',
		'.htaccess',
		'.project',
		'.settings',
		'include/config.inc.php',
		'propel-project'
	);
$zip->addDir('kalkuli', $excludeFileset);

$zip->close();

echo $archiveFilename . "\n";

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
		$nodes = glob($path . '/*');
		if (isset($concatPath))
			$concatPath .= '/' . $path;
		else
			$concatPath = '';
		
		foreach ($nodes as $node) {
			if (is_dir($node))
				$this->addDir($node, $excludeFileset);
			else if (is_file($node) && !in_array($concatPath . '/' . $node, $excludeFileset))
				$this->addFile($node);
		}
	}
}
