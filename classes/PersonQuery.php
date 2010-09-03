<?php



/**
 * Skeleton subclass for performing query and update operations on the 'person' table.
 *
 * List of person in the community
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class PersonQuery extends BasePersonQuery {

	public static function formOptionsArray () {
		
		$peopleList = self::create()
			->orderByPersonname()
			->find();

		$peopleOptions = array();
		foreach($peopleList as $person)
			$peopleOptions[$person->getPersonId()] = $person->getPersonName();
		
		return $peopleOptions;
	}

} // PersonQuery
