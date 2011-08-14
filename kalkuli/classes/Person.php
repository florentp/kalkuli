<?php



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
