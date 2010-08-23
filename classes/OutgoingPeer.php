<?php



/**
 * Skeleton subclass for performing query and update operations on the 'outgoing' table.
 *
 * What is consumed by the community
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class OutgoingPeer extends BaseOutgoingPeer {

	public static function computeTotal($person){
		
		$c = new Criteria();
		$c->add(OutgoingPeer::PERSONIDFK, $person);
		
		$outgoingsList = OutgoingPeer::doSelect($c);
		
		$total = 0;
		foreach ($outgoingsList as $outgoing)
			$total += $outgoing->computeWeightedPart();
		
		return $total;
		
	}

} // OutgoingPeer
