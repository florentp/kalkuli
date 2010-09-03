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
		
		return OutgoingQuery::create()
			->filterByOperation($this)
			->withColumn('SUM(OutWeight)', 'totalOutWeight')
			->groupBy('Operationidfk')
			->select('totalOutWeight')
			->findOne();
	}
	
	public function computeAmountTotal() {
		return IncomingQuery::create()
			->filterByOperation($this)
			->withColumn('SUM(InAmount)', 'totalInAmount')
			->groupBy('Operationidfk')
			->select('totalInAmount')
			->findOne();
	}

} // Operation
