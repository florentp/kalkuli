<?php



/**
 * This class defines the structure of the 'sheet' table.
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
class SheetTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'classes.map.SheetTableMap';

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
		$this->setName('sheet');
		$this->setPhpName('Sheet');
		$this->setClassname('Sheet');
		$this->setPackage('classes');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('SHEETID', 'Sheetid', 'INTEGER', true, null, null);
		$this->addColumn('ACCESSKEY', 'Accesskey', 'VARCHAR', true, 255, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
		$this->addColumn('CURRENCYCODE', 'Currencycode', 'VARCHAR', true, 255, null);
		$this->addColumn('CREATOREMAIL', 'Creatoremail', 'VARCHAR', true, 255, null);
		$this->addColumn('CREATIONTS', 'Creationts', 'TIMESTAMP', true, null, null);
		$this->addColumn('LASTMODIFICATIONTS', 'Lastmodificationts', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Person', 'Person', RelationMap::ONE_TO_MANY, array('sheetId' => 'sheetIdFK', ), 'CASCADE', null);
    $this->addRelation('Operation', 'Operation', RelationMap::ONE_TO_MANY, array('sheetId' => 'sheetIdFK', ), 'CASCADE', null);
	} // buildRelations()

} // SheetTableMap
