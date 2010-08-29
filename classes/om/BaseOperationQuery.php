<?php


/**
 * Base class that represents a query for the 'operation' table.
 *
 * List of operations (made of incomings and outgoings)
 *
 * @method     OperationQuery orderByOperationid($order = Criteria::ASC) Order by the operationId column
 * @method     OperationQuery orderByOperationts($order = Criteria::ASC) Order by the operationTS column
 * @method     OperationQuery orderByOperationdescription($order = Criteria::ASC) Order by the operationDescription column
 *
 * @method     OperationQuery groupByOperationid() Group by the operationId column
 * @method     OperationQuery groupByOperationts() Group by the operationTS column
 * @method     OperationQuery groupByOperationdescription() Group by the operationDescription column
 *
 * @method     OperationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     OperationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     OperationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     OperationQuery leftJoinOutgoing($relationAlias = null) Adds a LEFT JOIN clause to the query using the Outgoing relation
 * @method     OperationQuery rightJoinOutgoing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Outgoing relation
 * @method     OperationQuery innerJoinOutgoing($relationAlias = null) Adds a INNER JOIN clause to the query using the Outgoing relation
 *
 * @method     OperationQuery leftJoinIncoming($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incoming relation
 * @method     OperationQuery rightJoinIncoming($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incoming relation
 * @method     OperationQuery innerJoinIncoming($relationAlias = null) Adds a INNER JOIN clause to the query using the Incoming relation
 *
 * @method     Operation findOne(PropelPDO $con = null) Return the first Operation matching the query
 * @method     Operation findOneOrCreate(PropelPDO $con = null) Return the first Operation matching the query, or a new Operation object populated from the query conditions when no match is found
 *
 * @method     Operation findOneByOperationid(int $operationId) Return the first Operation filtered by the operationId column
 * @method     Operation findOneByOperationts(string $operationTS) Return the first Operation filtered by the operationTS column
 * @method     Operation findOneByOperationdescription(string $operationDescription) Return the first Operation filtered by the operationDescription column
 *
 * @method     array findByOperationid(int $operationId) Return Operation objects filtered by the operationId column
 * @method     array findByOperationts(string $operationTS) Return Operation objects filtered by the operationTS column
 * @method     array findByOperationdescription(string $operationDescription) Return Operation objects filtered by the operationDescription column
 *
 * @package    propel.generator.classes.om
 */
abstract class BaseOperationQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseOperationQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'money', $modelName = 'Operation', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new OperationQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    OperationQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof OperationQuery) {
			return $criteria;
		}
		$query = new OperationQuery();
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
	 * @return    Operation|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = OperationPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(OperationPeer::OPERATIONID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(OperationPeer::OPERATIONID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the operationId column
	 * 
	 * @param     int|array $operationid The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByOperationid($operationid = null, $comparison = null)
	{
		if (is_array($operationid) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(OperationPeer::OPERATIONID, $operationid, $comparison);
	}

	/**
	 * Filter the query on the operationTS column
	 * 
	 * @param     string|array $operationts The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByOperationts($operationts = null, $comparison = null)
	{
		if (is_array($operationts)) {
			$useMinMax = false;
			if (isset($operationts['min'])) {
				$this->addUsingAlias(OperationPeer::OPERATIONTS, $operationts['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($operationts['max'])) {
				$this->addUsingAlias(OperationPeer::OPERATIONTS, $operationts['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(OperationPeer::OPERATIONTS, $operationts, $comparison);
	}

	/**
	 * Filter the query on the operationDescription column
	 * 
	 * @param     string $operationdescription The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByOperationdescription($operationdescription = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($operationdescription)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $operationdescription)) {
				$operationdescription = str_replace('*', '%', $operationdescription);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(OperationPeer::OPERATIONDESCRIPTION, $operationdescription, $comparison);
	}

	/**
	 * Filter the query by a related Outgoing object
	 *
	 * @param     Outgoing $outgoing  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByOutgoing($outgoing, $comparison = null)
	{
		return $this
			->addUsingAlias(OperationPeer::OPERATIONID, $outgoing->getOperationidfk(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Outgoing relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    OperationQuery The current query, for fluid interface
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
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function filterByIncoming($incoming, $comparison = null)
	{
		return $this
			->addUsingAlias(OperationPeer::OPERATIONID, $incoming->getOperationidfk(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Incoming relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    OperationQuery The current query, for fluid interface
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
	 * @param     Operation $operation Object to remove from the list of results
	 *
	 * @return    OperationQuery The current query, for fluid interface
	 */
	public function prune($operation = null)
	{
		if ($operation) {
			$this->addUsingAlias(OperationPeer::OPERATIONID, $operation->getOperationid(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseOperationQuery
