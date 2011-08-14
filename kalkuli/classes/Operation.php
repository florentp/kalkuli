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
		
		return $this->getTotalOutWeight() != 0 ? $this->getTotalInAmount() / $this->getTotalOutWeight() : 0;
		
	}

} // Operation
