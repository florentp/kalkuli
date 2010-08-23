<?php



/**
 * This class defines the structure of the 'incoming' table.
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
class IncomingTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'classes.map.IncomingTableMap';

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
		$this->setName('incoming');
		$this->setPhpName('Incoming');
		$this->setClassname('Incoming');
		$this->setPackage('classes');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('INID', 'Inid', 'INTEGER', true, null, null);
		$this->addColumn('INAMOUNT', 'Inamount', 'FLOAT', false, null, null);
		$this->addForeignKey('OPERATIONIDFK', 'Operationidfk', 'INTEGER', 'operation', 'OPERATIONID', true, null, null);
		$this->addForeignKey('PERSONIDFK', 'Personidfk', 'INTEGER', 'person', 'PERSONID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Operation', 'Operation', RelationMap::MANY_TO_ONE, array('operationIdFK' => 'operationId', ), 'CASCADE', null);
    $this->addRelation('Person', 'Person', RelationMap::MANY_TO_ONE, array('personIdFK' => 'personId', ), 'CASCADE', null);
	} // buildRelations()

} // IncomingTableMap