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
 * Skeleton subclass for representing a row from the 'person' table.
 *
 * List of person in the community
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class Person extends BasePerson {

	public function getBalance() {
		
		$incomingsSum = IncomingQuery::create()
			->filterByPerson($this)
			->withColumn('SUM(InAmount)', 'totalInAmount')
			->groupBy('Personidfk')
			->select('totalInAmount')
			->findOne();

		$outgoingsList = OutgoingQuery::create()
			->filterByPerson($this)
			->joinWith('Outgoing.Operation')
			->find();

		$outgoingsSum = 0;
		foreach ($outgoingsList as $outgoing) {
			$totalInAmount = $outgoing->getOperation()->getTotalInAmount();
			$totalOutWeight = $outgoing->getOperation()->getTotalOutWeight();
			$outWeight = $outgoing->getOutWeight();
			$outgoingsSum += $outWeight * ($totalOutWeight == 0 ? 0 : $totalInAmount / $totalOutWeight);
		}

		return $incomingsSum - $outgoingsSum;
		
	}

} // Person
