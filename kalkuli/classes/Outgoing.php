<?php



/**
 * Skeleton subclass for representing a row from the 'outgoing' table.
 *
 * What is consumed by the community
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class Outgoing extends BaseOutgoing {

	public function computeWeightedPart() {
		return -$this->getOutWeight() * $this->getOperation()->computePart();
	}
	
	public function getOperationTS() {
		return $this->getOperation()->getOperationTS(DATE_FORMAT);
	}
	
	public function getOperationDescription() {
		return $this->getOperation()->getOperationDescription();
	}
	
	public function getOperationTotalInAmount() {
		return $this->getOperation()->getTotalInAmount();
	}
	
	public function getOperationTotalOutWeight() {
		return $this->getOperation()->getTotalOutWeight();
	}
	
	public function getPersonName() {
		return $this->getPerson()->getPersonName();
	}
	
	public function getPersonId() {
		return $this->getPerson()->getPersonId();
	}

} // Outgoing
