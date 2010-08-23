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
		
		$incomingsSum = IncomingPeer::computeTotal($this->getPersonId());
		$outgoingsSum = OutgoingPeer::computeTotal($this->getPersonId());
		
		return $incomingsSum - $outgoingsSum;
		
	}

} // Person
