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

		$outgoingsSum = 0;
		foreach ($this->getOutgoings() as $outgoing)
			$outgoingsSum += $outgoing->computeWeightedPart();
		
		return $incomingsSum - $outgoingsSum;
		
	}

} // Person
