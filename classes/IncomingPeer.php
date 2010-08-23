<?php



/**
 * Skeleton subclass for performing query and update operations on the 'incoming' table.
 *
 * What is shared by the community
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class IncomingPeer extends BaseIncomingPeer {

	public static function computeTotal($person){
		
		$c = new Criteria();
		$c->add(IncomingPeer::PERSONIDFK, $person);
		
		$incomingsList = IncomingPeer::doSelect($c);
		
		$total = 0;
		foreach ($incomingsList as $incoming)
			$total += $incoming->getInAmount();
		
		return $total;
		
	}

} // IncomingPeer
