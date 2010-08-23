<?php



/**
 * This class defines the structure of the 'operation' table.
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
class OperationTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'classes.map.OperationTableMap';

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
		$this->setName('operation');
		$this->setPhpName('Operation');
		$this->setClassname('Operation');
		$this->setPackage('classes');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('OPERATIONID', 'Operationid', 'INTEGER', true, null, null);
		$this->addColumn('OPERATIONTS', 'Operationts', 'TIMESTAMP', true, null, null);
		$this->addColumn('OPERATIONDESCRIPTION', 'Operationdescription', 'LONGVARCHAR', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Outgoing', 'Outgoing', RelationMap::ONE_TO_MANY, array('operationId' => 'operationIdFK', ), 'CASCADE', null);
    $this->addRelation('Incoming', 'Incoming', RelationMap::ONE_TO_MANY, array('operationId' => 'operationIdFK', ), 'CASCADE', null);
	} // buildRelations()

} // OperationTableMap
