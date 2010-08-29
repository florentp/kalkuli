<?php


/**
 * Base class that represents a query for the 'outgoing' table.
 *
 * What is consumed by the community
 *
 * @method     OutgoingQuery orderByOutid($order = Criteria::ASC) Order by the outId column
 * @method     OutgoingQuery orderByOutweight($order = Criteria::ASC) Order by the outWeight column
 * @method     OutgoingQuery orderByOperationidfk($order = Criteria::ASC) Order by the operationIdFK column
 * @method     OutgoingQuery orderByPersonidfk($order = Criteria::ASC) Order by the personIdFK column
 *
 * @method     OutgoingQuery groupByOutid() Group by the outId column
 * @method     OutgoingQuery groupByOutweight() Group by the outWeight column
 * @method     OutgoingQuery groupByOperationidfk() Group by the operationIdFK column
 * @method     OutgoingQuery groupByPersonidfk() Group by the personIdFK column
 *
 * @method     OutgoingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     OutgoingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     OutgoingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     OutgoingQuery leftJoinOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Operation relation
 * @method     OutgoingQuery rightJoinOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Operation relation
 * @method     OutgoingQuery innerJoinOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the Operation relation
 *
 * @method     OutgoingQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     OutgoingQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     OutgoingQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     Outgoing findOne(PropelPDO $con = null) Return the first Outgoing matching the query
 * @method     Outgoing findOneOrCreate(PropelPDO $con = null) Return the first Outgoing matching the query, or a new Outgoing object populated from the query conditions when no match is found
 *
 * @method     Outgoing findOneByOutid(int $outId) Return the first Outgoing filtered by the outId column
 * @method     Outgoing findOneByOutweight(double $outWeight) Return the first Outgoing filtered by the outWeight column
 * @method     Outgoing findOneByOperationidfk(int $operationIdFK) Return the first Outgoing filtered by the operationIdFK column
 * @method     Outgoing findOneByPersonidfk(int $personIdFK) Return the first Outgoing filtered by the personIdFK column
 *
 * @method     array findByOutid(int $outId) Return Outgoing objects filtered by the outId column
 * @method     array findByOutweight(double $outWeight) Return Outgoing objects filtered by the outWeight column
 * @method     array findByOperationidfk(int $operationIdFK) Return Outgoing objects filtered by the operationIdFK column
 * @method     array findByPersonidfk(int $personIdFK) Return Outgoing objects filtered by the personIdFK column
 *
 * @package    propel.generator.classes.om
 */
abstract class BaseOutgoingQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseOutgoingQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'money', $modelName = 'Outgoing', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new OutgoingQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    OutgoingQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof OutgoingQuery) {
			return $criteria;
		}
		$query = new OutgoingQuery();
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
	 * @return    Outgoing|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = OutgoingPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(OutgoingPeer::OUTID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(OutgoingPeer::OUTID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the outId column
	 * 
	 * @param     int|array $outid The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByOutid($outid = null, $comparison = null)
	{
		if (is_array($outid) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(OutgoingPeer::OUTID, $outid, $comparison);
	}

	/**
	 * Filter the query on the outWeight column
	 * 
	 * @param     double|array $outweight The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByOutweight($outweight = null, $comparison = null)
	{
		if (is_array($outweight)) {
			$useMinMax = false;
			if (isset($outweight['min'])) {
				$this->addUsingAlias(OutgoingPeer::OUTWEIGHT, $outweight['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($outweight['max'])) {
				$this->addUsingAlias(OutgoingPeer::OUTWEIGHT, $outweight['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(OutgoingPeer::OUTWEIGHT, $outweight, $comparison);
	}

	/**
	 * Filter the query on the operationIdFK column
	 * 
	 * @param     int|array $operationidfk The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByOperationidfk($operationidfk = null, $comparison = null)
	{
		if (is_array($operationidfk)) {
			$useMinMax = false;
			if (isset($operationidfk['min'])) {
				$this->addUsingAlias(OutgoingPeer::OPERATIONIDFK, $operationidfk['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($operationidfk['max'])) {
				$this->addUsingAlias(OutgoingPeer::OPERATIONIDFK, $operationidfk['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(OutgoingPeer::OPERATIONIDFK, $operationidfk, $comparison);
	}

	/**
	 * Filter the query on the personIdFK column
	 * 
	 * @param     int|array $personidfk The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByPersonidfk($personidfk = null, $comparison = null)
	{
		if (is_array($personidfk)) {
			$useMinMax = false;
			if (isset($personidfk['min'])) {
				$this->addUsingAlias(OutgoingPeer::PERSONIDFK, $personidfk['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($personidfk['max'])) {
				$this->addUsingAlias(OutgoingPeer::PERSONIDFK, $personidfk['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(OutgoingPeer::PERSONIDFK, $personidfk, $comparison);
	}

	/**
	 * Filter the query by a related Operation object
	 *
	 * @param     Operation $operation  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByOperation($operation, $comparison = null)
	{
		return $this
			->addUsingAlias(OutgoingPeer::OPERATIONIDFK, $operation->getOperationid(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Operation relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function joinOperation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Operation');
		
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
			$this->addJoinObject($join, 'Operation');
		}
		
		return $this;
	}

	/**
	 * Use the Operation relation Operation object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    OperationQuery A secondary query class using the current class as primary query
	 */
	public function useOperationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinOperation($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Operation', 'OperationQuery');
	}

	/**
	 * Filter the query by a related Person object
	 *
	 * @param     Person $person  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function filterByPerson($person, $comparison = null)
	{
		return $this
			->addUsingAlias(OutgoingPeer::PERSONIDFK, $person->getPersonid(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Person relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function joinPerson($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Person');
		
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
			$this->addJoinObject($join, 'Person');
		}
		
		return $this;
	}

	/**
	 * Use the Person relation Person object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PersonQuery A secondary query class using the current class as primary query
	 */
	public function usePersonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPerson($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Person', 'PersonQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Outgoing $outgoing Object to remove from the list of results
	 *
	 * @return    OutgoingQuery The current query, for fluid interface
	 */
	public function prune($outgoing = null)
	{
		if ($outgoing) {
			$this->addUsingAlias(OutgoingPeer::OUTID, $outgoing->getOutid(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseOutgoingQuery
