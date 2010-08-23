<?php



/**
 * Skeleton subclass for representing a row from the 'operation' table.
 *
 * List of operations (made of incomings and outgoings)
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class Operation extends BaseOperation {

	public function computePart(){
		
		$amountTotal = $this->computeAmountTotal();
		$weightTotal = $this->computeWeightTotal();
		
		return $weightTotal != 0 ? $amountTotal / $weightTotal : 0;
		
	}
	
	public function computeWeightTotal(){
		
		$c = new Criteria();
		$c->add(OutgoingPeer::OPERATIONIDFK, $this->getOperationId());
		
		$outgoingsList = OutgoingPeer::doSelect($c);
		
		$weightTotal = 0;
		foreach ($outgoingsList as $outgoing)
			$weightTotal += $outgoing->getOutWeight();
		
		return $weightTotal;
		
	}
	
	public function computeAmountTotal() {
		
		$c = new Criteria();
		$c->add(IncomingPeer::OPERATIONIDFK, $this->getOperationId());
		
		$incomingsList = IncomingPeer::doSelect($c);
		
		$amountTotal = 0;
		foreach ($incomingsList as $incoming)
			$amountTotal += $incoming->getInAmount();
		
		return $amountTotal;
		
	}

} // Operation
