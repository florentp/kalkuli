<?php



/**
 * This class defines the structure of the 'person' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.classes.map
 */
class PersonTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'classes.map.PersonTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('person');
		$this->setPhpName('Person');
		$this->setClassname('Person');
		$this->setPackage('classes');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('PERSONID', 'Personid', 'INTEGER', true, null, null);
		$this->addColumn('PERSONNAME', 'Personname', 'VARCHAR', true, 255, null);
		$this->addForeignKey('SHEETIDFK', 'Sheetidfk', 'INTEGER', 'sheet', 'SHEETID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Sheet', 'Sheet', RelationMap::MANY_TO_ONE, array('sheetIdFK' => 'sheetId', ), 'CASCADE', null);
    $this->addRelation('Outgoing', 'Outgoing', RelationMap::ONE_TO_MANY, array('personId' => 'personIdFK', ), 'CASCADE', null);
    $this->addRelation('Incoming', 'Incoming', RelationMap::ONE_TO_MANY, array('personId' => 'personIdFK', ), 'CASCADE', null);
	} // buildRelations()

} // PersonTableMap
