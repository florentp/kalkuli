<?php


/**
 * Base class that represents a query for the 'person' table.
 *
 * List of person in the community
 *
 * @method     PersonQuery orderByPersonid($order = Criteria::ASC) Order by the personId column
 * @method     PersonQuery orderByPersonname($order = Criteria::ASC) Order by the personName column
 * @method     PersonQuery orderBySheetidfk($order = Criteria::ASC) Order by the sheetIdFK column
 *
 * @method     PersonQuery groupByPersonid() Group by the personId column
 * @method     PersonQuery groupByPersonname() Group by the personName column
 * @method     PersonQuery groupBySheetidfk() Group by the sheetIdFK column
 *
 * @method     PersonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     PersonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     PersonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     PersonQuery leftJoinSheet($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sheet relation
 * @method     PersonQuery rightJoinSheet($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sheet relation
 * @method     PersonQuery innerJoinSheet($relationAlias = null) Adds a INNER JOIN clause to the query using the Sheet relation
 *
 * @method     PersonQuery leftJoinOutgoing($relationAlias = null) Adds a LEFT JOIN clause to the query using the Outgoing relation
 * @method     PersonQuery rightJoinOutgoing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Outgoing relation
 * @method     PersonQuery innerJoinOutgoing($relationAlias = null) Adds a INNER JOIN clause to the query using the Outgoing relation
 *
 * @method     PersonQuery leftJoinIncoming($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incoming relation
 * @method     PersonQuery rightJoinIncoming($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incoming relation
 * @method     PersonQuery innerJoinIncoming($relationAlias = null) Adds a INNER JOIN clause to the query using the Incoming relation
 *
 * @method     Person findOne(PropelPDO $con = null) Return the first Person matching the query
 * @method     Person findOneOrCreate(PropelPDO $con = null) Return the first Person matching the query, or a new Person object populated from the query conditions when no match is found
 *
 * @method     Person findOneByPersonid(int $personId) Return the first Person filtered by the personId column
 * @method     Person findOneByPersonname(string $personName) Return the first Person filtered by the personName column
 * @method     Person findOneBySheetidfk(int $sheetIdFK) Return the first Person filtered by the sheetIdFK column
 *
 * @method     array findByPersonid(int $personId) Return Person objects filtered by the personId column
 * @method     array findByPersonname(string $personName) Return Person objects filtered by the personName column
 * @method     array findBySheetidfk(int $sheetIdFK) Return Person objects filtered by the sheetIdFK column
 *
 * @package    propel.generator.classes.om
 */
abstract class BasePersonQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BasePersonQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'kalkuli', $modelName = 'Person', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new PersonQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    PersonQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof PersonQuery) {
			return $criteria;
		}
		$query = new PersonQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    Person|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = PersonPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			$criteria = $this->isKeepQuery() ? clone $this : $this;
			$stmt = $criteria
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
		}
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{	
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(PersonPeer::PERSONID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(PersonPeer::PERSONID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the personId column
	 * 
	 * @param     int|array $personid The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterByPersonid($personid = null, $comparison = null)
	{
		if (is_array($personid) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(PersonPeer::PERSONID, $personid, $comparison);
	}

	/**
	 * Filter the query on the personName column
	 * 
	 * @param     string $personname The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterByPersonname($personname = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($personname)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $personname)) {
				$personname = str_replace('*', '%', $personname);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PersonPeer::PERSONNAME, $personname, $comparison);
	}

	/**
	 * Filter the query on the sheetIdFK column
	 * 
	 * @param     int|array $sheetidfk The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterBySheetidfk($sheetidfk = null, $comparison = null)
	{
		if (is_array($sheetidfk)) {
			$useMinMax = false;
			if (isset($sheetidfk['min'])) {
				$this->addUsingAlias(PersonPeer::SHEETIDFK, $sheetidfk['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($sheetidfk['max'])) {
				$this->addUsingAlias(PersonPeer::SHEETIDFK, $sheetidfk['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PersonPeer::SHEETIDFK, $sheetidfk, $comparison);
	}

	/**
	 * Filter the query by a related Sheet object
	 *
	 * @param     Sheet $sheet  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterBySheet($sheet, $comparison = null)
	{
		return $this
			->addUsingAlias(PersonPeer::SHEETIDFK, $sheet->getSheetid(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Sheet relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function joinSheet($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Sheet');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Sheet');
		}
		
		return $this;
	}

	/**
	 * Use the Sheet relation Sheet object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SheetQuery A secondary query class using the current class as primary query
	 */
	public function useSheetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinSheet($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Sheet', 'SheetQuery');
	}

	/**
	 * Filter the query by a related Outgoing object
	 *
	 * @param     Outgoing $outgoing  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterByOutgoing($outgoing, $comparison = null)
	{
		return $this
			->addUsingAlias(PersonPeer::PERSONID, $outgoing->getPersonidfk(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Outgoing relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function joinOutgoing($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Outgoing');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Outgoing');
		}
		
		return $this;
	}

	/**
	 * Use the Outgoing relation Outgoing object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    OutgoingQuery A secondary query class using the current class as primary query
	 */
	public function useOutgoingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinOutgoing($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Outgoing', 'OutgoingQuery');
	}

	/**
	 * Filter the query by a related Incoming object
	 *
	 * @param     Incoming $incoming  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function filterByIncoming($incoming, $comparison = null)
	{
		return $this
			->addUsingAlias(PersonPeer::PERSONID, $incoming->getPersonidfk(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Incoming relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function joinIncoming($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Incoming');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Incoming');
		}
		
		return $this;
	}

	/**
	 * Use the Incoming relation Incoming object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    IncomingQuery A secondary query class using the current class as primary query
	 */
	public function useIncomingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinIncoming($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Incoming', 'IncomingQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Person $person Object to remove from the list of results
	 *
	 * @return    PersonQuery The current query, for fluid interface
	 */
	public function prune($person = null)
	{
		if ($person) {
			$this->addUsingAlias(PersonPeer::PERSONID, $person->getPersonid(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BasePersonQuery
