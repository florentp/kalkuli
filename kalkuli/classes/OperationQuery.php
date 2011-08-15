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



/**
 * Skeleton subclass for performing query and update operations on the 'operation' table.
 *
 * List of operations (made of incomings and outgoings)
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class OperationQuery extends BaseOperationQuery {

	public function getPersonOperationList($personId) {
		$con = Propel::getConnection(OperationPeer::DATABASE_NAME);
		$sql = 
			"SELECT operation.*, i.personTotalInAmount personTotalInAmount, -(o.personTotalOutWeight / operation.totalOutWeight * operation.totalInAmount) personTotalOutAmount
			FROM operation
			LEFT JOIN (
					SELECT operationIdFK , SUM(inAmount) personTotalInAmount
					FROM incoming
					WHERE personIdFK = :personIdFK
					GROUP BY operationIdFK
				) i
				ON i.operationIdFK = operation.operationId
			LEFT JOIN (
					SELECT operationIdFK , SUM(outWeight) personTotalOutWeight
					FROM outgoing
					WHERE personIdFK = :personIdFK
					GROUP BY operationIdFK
				) o
				ON o.operationIdFK = operation.operationId
			WHERE i.personTotalInAmount IS NOT NULL OR o.personTotalOutWeight IS NOT NULL
			ORDER BY operation.operationTS DESC";
		
		$stmt = $con->prepare($sql);
		$stmt->execute(array(':personIdFK' => $personId));

		$formatter = new PropelObjectFormatter($this);
		$formatter->setAsColumns(array(
				'Persontotalinamount' => 'personTotalInAmount',
				'Persontotaloutamount' => 'personTotalOutAmount'
			));
		$operationsList = $formatter->format($stmt);
		return $operationsList;
	}

} // OperationQuery
