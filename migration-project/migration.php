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

include_once('config.inc.php');

$destinationSheetKey = DESTINATION_SHEET_KEY;

echo "Open SQLite source datebase ... ";
try {
	$sqlitePdo = new PDO('sqlite:' . SQLITE_DB_FILEPATH);
	$sqlitePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Done\n";
}
catch (PDOException $e) {
	echo "Error\n";
	throw $e;
}

echo "Connecting to MySQL destination database ... ";
try {
	$mysqlPdo = new PDO('mysql:host=' . MYSQL_DB_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_DB_USERNAME, MYSQL_DB_PASSWORD);
	$mysqlPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Done\n";
}
catch (PDOException $e) {
	echo "Error\n";
	throw $e;
}

// Retrieve sheet from destination DB
$statement = $mysqlPdo->prepare('select * from sheet where accessKey = :accessKey');
$statement->bindParam(':accessKey', $destinationSheetKey, PDO::PARAM_STR);
$statement->execute();
$sheet = $statement->fetch();

if (!$sheet) {
	throw new Exception("Sheet with key $destinationSheetKey not found.");
}

// Check no participant is already present in the destination sheet
$statement = $mysqlPdo->prepare('select * from person where sheetIdFK = :sheetIdFK');
$statement->bindParam(':sheetIdFK', $sheet['sheetId'], PDO::PARAM_INT);
$statement->execute();
$participantList = $statement->fetchAll();

if (count($participantList) > 0) {
	throw new Exception("Cannot import data in in sheet $sheet[name] because some participants are already present.");
}
	
// Check no operation is already present in the destination sheet
$statement = $mysqlPdo->prepare('select * from operation where sheetIdFK = :sheetIdFK');
$statement->bindParam(':sheetIdFK', $sheet['sheetId'], PDO::PARAM_INT);
$statement->execute();
$operationList = $statement->fetchAll();

if (count($operationList) > 0) {
	throw new Exception("Cannot import data in in sheet $sheet[name] because some operations are already present.");
}

// Retrieve participants list from source DB
$statement = $sqlitePdo->prepare('select * from person');
$statement->execute();
$peopleList = $statement->fetchAll();
if (count($peopleList) == 0) {
	throw new Exception("Cannot import data from source DB, no participant found");
}
echo count($peopleList) . " participants found.\n";

// Retrieve operations list from source DB
$statement = $sqlitePdo->prepare('select * from operation');
$statement->execute();
$operationList = $statement->fetchAll();
if (count($operationList) == 0) {
	throw new Exception("Cannot import data from source DB, no operation found");
}
echo count($operationList) . " operations found.\n";

try {
	$mysqlPdo->beginTransaction();
	
	$peopleMapping = array();
	$statement = $mysqlPdo->prepare("insert into person (personName, sheetIdFK) values (:personName, :sheetIdFK)");
	foreach ($peopleList as $person) {
		echo "Creating new participant $person[personName] ... ";
		$statement->bindParam(':personName', $person['personName']);
		$statement->bindParam(':sheetIdFK', $sheet['sheetId']);
		$statement->execute();
		$peopleMapping[$person['personId']] = $mysqlPdo->lastInsertid();
		echo "Done\n";
	}
	
	$operationsMapping = array();
	
	$statement = $mysqlPdo->prepare("insert into operation (operationTS, operationDescription, sheetIdFK) values (:operationTS, :operationDescription, :sheetIdFK)");
	$selectIncomingStatement = $sqlitePdo->prepare("select * from incoming where operationIdFK = :operationIdFK");
	$selectOutgoingStatement = $sqlitePdo->prepare("select * from outgoing where operationIdFK = :operationIdFK");
	$insertIncomingStatement = $mysqlPdo->prepare("insert into incoming (inAmount, operationIdFK, personIdFK) values (:inAmount, :operationIdFK, :personIdFK)");
	$insertOutgoingStatement = $mysqlPdo->prepare("insert into outgoing (outWeight, operationIdFK, personIdFK) values (:outWeight, :operationIdFK, :personIdFK)");
	
	$nSkipOperation = 0;
	
	foreach ($operationList as $operation) {
		echo "Processing operation $operation[operationDescription] ($operation[operationTS]) ... ";
		
		$selectIncomingStatement->bindParam(":operationIdFK", $operation['operationId']);
		$selectIncomingStatement->execute();
		$incomingList = $selectIncomingStatement->fetchAll();
		
		$selectOutgoingStatement->bindParam(":operationIdFK", $operation['operationId']);
		$selectOutgoingStatement->execute();
		$outgoingList = $selectOutgoingStatement->fetchAll();
		
		if (count($incomingList) == 0 || count($outgoingList) == 0) {
			echo "Skip (empty operation)\n";
			$nSkipOperation++;
			continue;
		}
		
		$statement->bindParam(':operationTS', $operation['operationTS']);
		$statement->bindParam(':operationDescription', $operation['operationDescription']);
		$statement->bindParam(':sheetIdFK', $sheet['sheetId']);
		$statement->execute();
		$newOperationId = $mysqlPdo->lastInsertid();
		
		foreach ($incomingList as $incoming) {
			$insertIncomingStatement->bindParam(":inAmount", $incoming['inAmount']);
			$insertIncomingStatement->bindParam(":operationIdFK", $newOperationId);
			$insertIncomingStatement->bindParam(":personIdFK", $peopleMapping[$incoming['personIdFK']]);
			$insertIncomingStatement->execute();
		}
		
		foreach ($outgoingList as $outgoing) {
			$insertOutgoingStatement->bindParam(":outWeight", $outgoing['outWeight']);
			$insertOutgoingStatement->bindParam(":operationIdFK", $newOperationId);
			$insertOutgoingStatement->bindParam(":personIdFK", $peopleMapping[$outgoing['personIdFK']]);
			$insertOutgoingStatement->execute();
		}
		
		echo "Done\n";
	}
	
	$mysqlPdo->commit();
}
catch (Exception $e) {
	$mysqlPdo->rollBack();
	throw $e;
}

echo "\n";
echo count($operationList) . " operations processed (" . (count($operationList) - $nSkipOperation) . " created, $nSkipOperation skipped)\n";

echo "\n";
