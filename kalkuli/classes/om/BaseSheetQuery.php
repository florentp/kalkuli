<?php


/**
 * Base class that represents a query for the 'sheet' table.
 *
 * List of sheets
 *
 * @method     SheetQuery orderBySheetid($order = Criteria::ASC) Order by the sheetId column
 * @method     SheetQuery orderByAccesskey($order = Criteria::ASC) Order by the accessKey column
 * @method     SheetQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     SheetQuery orderByCurrencycode($order = Criteria::ASC) Order by the currencyCode column
 * @method     SheetQuery orderByCreatoremail($order = Criteria::ASC) Order by the creatorEmail column
 * @method     SheetQuery orderByCreationts($order = Criteria::ASC) Order by the creationTS column
 * @method     SheetQuery orderByLastmodificationts($order = Criteria::ASC) Order by the lastModificationTS column
 *
 * @method     SheetQuery groupBySheetid() Group by the sheetId column
 * @method     SheetQuery groupByAccesskey() Group by the accessKey column
 * @method     SheetQuery groupByName() Group by the name column
 * @method     SheetQuery groupByCurrencycode() Group by the currencyCode column
 * @method     SheetQuery groupByCreatoremail() Group by the creatorEmail column
 * @method     SheetQuery groupByCreationts() Group by the creationTS column
 * @method     SheetQuery groupByLastmodificationts() Group by the lastModificationTS column
 *
 * @method     SheetQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     SheetQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     SheetQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     SheetQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     SheetQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     SheetQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     SheetQuery leftJoinOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Operation relation
 * @method     SheetQuery rightJoinOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Operation relation
 * @method     SheetQuery innerJoinOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the Operation relation
 *
 * @method     Sheet findOne(PropelPDO $con = null) Return the first Sheet matching the query
 * @method     Sheet findOneOrCreate(PropelPDO $con = null) Return the first Sheet matching the query, or a new Sheet object populated from the query conditions when no match is found
 *
 * @method     Sheet findOneBySheetid(int $sheetId) Return the first Sheet filtered by the sheetId column
 * @method     Sheet findOneByAccesskey(string $accessKey) Return the first Sheet filtered by the accessKey column
 * @method     Sheet findOneByName(string $name) Return the first Sheet filtered by the name column
 * @method     Sheet findOneByCurrencycode(string $currencyCode) Return the first Sheet filtered by the currencyCode column
 * @method     Sheet findOneByCreatoremail(string $creatorEmail) Return the first Sheet filtered by the creatorEmail column
 * @method     Sheet findOneByCreationts(string $creationTS) Return the first Sheet filtered by the creationTS column
 * @method     Sheet findOneByLastmodificationts(string $lastModificationTS) Return the first Sheet filtered by the lastModificationTS column
 *
 * @method     array findBySheetid(int $sheetId) Return Sheet objects filtered by the sheetId column
 * @method     array findByAccesskey(string $accessKey) Return Sheet objects filtered by the accessKey column
 * @method     array findByName(string $name) Return Sheet objects filtered by the name column
 * @method     array findByCurrencycode(string $currencyCode) Return Sheet objects filtered by the currencyCode column
 * @method     array findByCreatoremail(string $creatorEmail) Return Sheet objects filtered by the creatorEmail column
 * @method     array findByCreationts(string $creationTS) Return Sheet objects filtered by the creationTS column
 * @method     array findByLastmodificationts(string $lastModificationTS) Return Sheet objects filtered by the lastModificationTS column
 *
 * @package    propel.generator.classes.om
 */
abstract class BaseSheetQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseSheetQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'kalkuli', $modelName = 'Sheet', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new SheetQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    SheetQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof SheetQuery) {
			return $criteria;
		}
		$query = new SheetQuery();
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
	 * @return    Sheet|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = SheetPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(SheetPeer::SHEETID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(SheetPeer::SHEETID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the sheetId column
	 * 
	 * @param     int|array $sheetid The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterBySheetid($sheetid = null, $comparison = null)
	{
		if (is_array($sheetid) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(SheetPeer::SHEETID, $sheetid, $comparison);
	}

	/**
	 * Filter the query on the accessKey column
	 * 
	 * @param     string $accesskey The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByAccesskey($accesskey = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($accesskey)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $accesskey)) {
				$accesskey = str_replace('*', '%', $accesskey);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SheetPeer::ACCESSKEY, $accesskey, $comparison);
	}

	/**
	 * Filter the query on the name column
	 * 
	 * @param     string $name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($name)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $name)) {
				$name = str_replace('*', '%', $name);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SheetPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the currencyCode column
	 * 
	 * @param     string $currencycode The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByCurrencycode($currencycode = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($currencycode)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $currencycode)) {
				$currencycode = str_replace('*', '%', $currencycode);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SheetPeer::CURRENCYCODE, $currencycode, $comparison);
	}

	/**
	 * Filter the query on the creatorEmail column
	 * 
	 * @param     string $creatoremail The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByCreatoremail($creatoremail = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($creatoremail)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $creatoremail)) {
				$creatoremail = str_replace('*', '%', $creatoremail);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(SheetPeer::CREATOREMAIL, $creatoremail, $comparison);
	}

	/**
	 * Filter the query on the creationTS column
	 * 
	 * @param     string|array $creationts The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByCreationts($creationts = null, $comparison = null)
	{
		if (is_array($creationts)) {
			$useMinMax = false;
			if (isset($creationts['min'])) {
				$this->addUsingAlias(SheetPeer::CREATIONTS, $creationts['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($creationts['max'])) {
				$this->addUsingAlias(SheetPeer::CREATIONTS, $creationts['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SheetPeer::CREATIONTS, $creationts, $comparison);
	}

	/**
	 * Filter the query on the lastModificationTS column
	 * 
	 * @param     string|array $lastmodificationts The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByLastmodificationts($lastmodificationts = null, $comparison = null)
	{
		if (is_array($lastmodificationts)) {
			$useMinMax = false;
			if (isset($lastmodificationts['min'])) {
				$this->addUsingAlias(SheetPeer::LASTMODIFICATIONTS, $lastmodificationts['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($lastmodificationts['max'])) {
				$this->addUsingAlias(SheetPeer::LASTMODIFICATIONTS, $lastmodificationts['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(SheetPeer::LASTMODIFICATIONTS, $lastmodificationts, $comparison);
	}

	/**
	 * Filter the query by a related Person object
	 *
	 * @param     Person $person  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByPerson($person, $comparison = null)
	{
		return $this
			->addUsingAlias(SheetPeer::SHEETID, $person->getSheetidfk(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Person relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SheetQuery The current query, for fluid interface
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
	 * Filter the query by a related Operation object
	 *
	 * @param     Operation $operation  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function filterByOperation($operation, $comparison = null)
	{
		return $this
			->addUsingAlias(SheetPeer::SHEETID, $operation->getSheetidfk(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Operation relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SheetQuery The current query, for fluid interface
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
	 * Exclude object from result
	 *
	 * @param     Sheet $sheet Object to remove from the list of results
	 *
	 * @return    SheetQuery The current query, for fluid interface
	 */
	public function prune($sheet = null)
	{
		if ($sheet) {
			$this->addUsingAlias(SheetPeer::SHEETID, $sheet->getSheetid(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseSheetQuery
