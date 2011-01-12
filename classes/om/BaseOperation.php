<?php


/**
 * Base class that represents a row from the 'operation' table.
 *
 * List of operations (made of incomings and outgoings)
 *
 * @package    propel.generator.classes.om
 */
abstract class BaseOperation extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
  const PEER = 'OperationPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        OperationPeer
	 */
	protected static $peer;

	/**
	 * The value for the operationid field.
	 * @var        int
	 */
	protected $operationid;

	/**
	 * The value for the operationts field.
	 * @var        string
	 */
	protected $operationts;

	/**
	 * The value for the operationdescription field.
	 * @var        string
	 */
	protected $operationdescription;

	/**
	 * The value for the sheetidfk field.
	 * @var        int
	 */
	protected $sheetidfk;

	/**
	 * The value for the totalinamount field.
	 * @var        double
	 */
	protected $totalinamount;

	/**
	 * The value for the totaloutweight field.
	 * @var        double
	 */
	protected $totaloutweight;

	/**
	 * @var        Sheet
	 */
	protected $aSheet;

	/**
	 * @var        array Outgoing[] Collection to store aggregation of Outgoing objects.
	 */
	protected $collOutgoings;

	/**
	 * @var        array Incoming[] Collection to store aggregation of Incoming objects.
	 */
	protected $collIncomings;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Get the [operationid] column value.
	 * Operation ID
	 * @return     int
	 */
	public function getOperationid()
	{
		return $this->operationid;
	}

	/**
	 * Get the [optionally formatted] temporal [operationts] column value.
	 * Operation date
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getOperationts($format = 'Y-m-d H:i:s')
	{
		if ($this->operationts === null) {
			return null;
		}


		if ($this->operationts === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->operationts);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->operationts, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [operationdescription] column value.
	 * Operation description
	 * @return     string
	 */
	public function getOperationdescription()
	{
		return $this->operationdescription;
	}

	/**
	 * Get the [sheetidfk] column value.
	 * Sheet foreign key
	 * @return     int
	 */
	public function getSheetidfk()
	{
		return $this->sheetidfk;
	}

	/**
	 * Get the [totalinamount] column value.
	 * Total amount of all incomings for this operation
	 * @return     double
	 */
	public function getTotalinamount()
	{
		return $this->totalinamount;
	}

	/**
	 * Get the [totaloutweight] column value.
	 * Total weight of all outgoings for this operation
	 * @return     double
	 */
	public function getTotaloutweight()
	{
		return $this->totaloutweight;
	}

	/**
	 * Set the value of [operationid] column.
	 * Operation ID
	 * @param      int $v new value
	 * @return     Operation The current object (for fluent API support)
	 */
	public function setOperationid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->operationid !== $v) {
			$this->operationid = $v;
			$this->modifiedColumns[] = OperationPeer::OPERATIONID;
		}

		return $this;
	} // setOperationid()

	/**
	 * Sets the value of [operationts] column to a normalized version of the date/time value specified.
	 * Operation date
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Operation The current object (for fluent API support)
	 */
	public function setOperationts($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->operationts !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->operationts !== null && $tmpDt = new DateTime($this->operationts)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->operationts = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = OperationPeer::OPERATIONTS;
			}
		} // if either are not null

		return $this;
	} // setOperationts()

	/**
	 * Set the value of [operationdescription] column.
	 * Operation description
	 * @param      string $v new value
	 * @return     Operation The current object (for fluent API support)
	 */
	public function setOperationdescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->operationdescription !== $v) {
			$this->operationdescription = $v;
			$this->modifiedColumns[] = OperationPeer::OPERATIONDESCRIPTION;
		}

		return $this;
	} // setOperationdescription()

	/**
	 * Set the value of [sheetidfk] column.
	 * Sheet foreign key
	 * @param      int $v new value
	 * @return     Operation The current object (for fluent API support)
	 */
	public function setSheetidfk($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sheetidfk !== $v) {
			$this->sheetidfk = $v;
			$this->modifiedColumns[] = OperationPeer::SHEETIDFK;
		}

		if ($this->aSheet !== null && $this->aSheet->getSheetid() !== $v) {
			$this->aSheet = null;
		}

		return $this;
	} // setSheetidfk()

	/**
	 * Set the value of [totalinamount] column.
	 * Total amount of all incomings for this operation
	 * @param      double $v new value
	 * @return     Operation The current object (for fluent API support)
	 */
	public function setTotalinamount($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->totalinamount !== $v) {
			$this->totalinamount = $v;
			$this->modifiedColumns[] = OperationPeer::TOTALINAMOUNT;
		}

		return $this;
	} // setTotalinamount()

	/**
	 * Set the value of [totaloutweight] column.
	 * Total weight of all outgoings for this operation
	 * @param      double $v new value
	 * @return     Operation The current object (for fluent API support)
	 */
	public function setTotaloutweight($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->totaloutweight !== $v) {
			$this->totaloutweight = $v;
			$this->modifiedColumns[] = OperationPeer::TOTALOUTWEIGHT;
		}

		return $this;
	} // setTotaloutweight()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->operationid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->operationts = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->operationdescription = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->sheetidfk = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->totalinamount = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
			$this->totaloutweight = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 6; // 6 = OperationPeer::NUM_COLUMNS - OperationPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Operation object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aSheet !== null && $this->sheetidfk !== $this->aSheet->getSheetid()) {
			$this->aSheet = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = OperationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aSheet = null;
			$this->collOutgoings = null;

			$this->collIncomings = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			if ($ret) {
				OperationQuery::create()
					->filterByPrimaryKey($this->getPrimaryKey())
					->delete($con);
				$this->postDelete($con);
				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				OperationPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aSheet !== null) {
				if ($this->aSheet->isModified() || $this->aSheet->isNew()) {
					$affectedRows += $this->aSheet->save($con);
				}
				$this->setSheet($this->aSheet);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = OperationPeer::OPERATIONID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					if ($criteria->keyContainsValue(OperationPeer::OPERATIONID) ) {
						throw new PropelException('Cannot insert a value for auto-increment primary key ('.OperationPeer::OPERATIONID.')');
					}

					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setOperationid($pk);  //[IMV] update autoincrement primary key
					$this->setNew(false);
				} else {
					$affectedRows += OperationPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collOutgoings !== null) {
				foreach ($this->collOutgoings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collIncomings !== null) {
				foreach ($this->collIncomings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aSheet !== null) {
				if (!$this->aSheet->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSheet->getValidationFailures());
				}
			}


			if (($retval = OperationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOutgoings !== null) {
					foreach ($this->collOutgoings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collIncomings !== null) {
					foreach ($this->collIncomings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OperationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getOperationid();
				break;
			case 1:
				return $this->getOperationts();
				break;
			case 2:
				return $this->getOperationdescription();
				break;
			case 3:
				return $this->getSheetidfk();
				break;
			case 4:
				return $this->getTotalinamount();
				break;
			case 5:
				return $this->getTotaloutweight();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. 
	 *                    Defaults to BasePeer::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $includeForeignObjects = false)
	{
		$keys = OperationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getOperationid(),
			$keys[1] => $this->getOperationts(),
			$keys[2] => $this->getOperationdescription(),
			$keys[3] => $this->getSheetidfk(),
			$keys[4] => $this->getTotalinamount(),
			$keys[5] => $this->getTotaloutweight(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aSheet) {
				$result['Sheet'] = $this->aSheet->toArray($keyType, $includeLazyLoadColumns, true);
			}
		}
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OperationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setOperationid($value);
				break;
			case 1:
				$this->setOperationts($value);
				break;
			case 2:
				$this->setOperationdescription($value);
				break;
			case 3:
				$this->setSheetidfk($value);
				break;
			case 4:
				$this->setTotalinamount($value);
				break;
			case 5:
				$this->setTotaloutweight($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OperationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setOperationid($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOperationts($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOperationdescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSheetidfk($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTotalinamount($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTotaloutweight($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(OperationPeer::DATABASE_NAME);

		if ($this->isColumnModified(OperationPeer::OPERATIONID)) $criteria->add(OperationPeer::OPERATIONID, $this->operationid);
		if ($this->isColumnModified(OperationPeer::OPERATIONTS)) $criteria->add(OperationPeer::OPERATIONTS, $this->operationts);
		if ($this->isColumnModified(OperationPeer::OPERATIONDESCRIPTION)) $criteria->add(OperationPeer::OPERATIONDESCRIPTION, $this->operationdescription);
		if ($this->isColumnModified(OperationPeer::SHEETIDFK)) $criteria->add(OperationPeer::SHEETIDFK, $this->sheetidfk);
		if ($this->isColumnModified(OperationPeer::TOTALINAMOUNT)) $criteria->add(OperationPeer::TOTALINAMOUNT, $this->totalinamount);
		if ($this->isColumnModified(OperationPeer::TOTALOUTWEIGHT)) $criteria->add(OperationPeer::TOTALOUTWEIGHT, $this->totaloutweight);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OperationPeer::DATABASE_NAME);
		$criteria->add(OperationPeer::OPERATIONID, $this->operationid);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getOperationid();
	}

	/**
	 * Generic method to set the primary key (operationid column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setOperationid($key);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return null === $this->getOperationid();
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Operation (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{
		$copyObj->setOperationts($this->operationts);
		$copyObj->setOperationdescription($this->operationdescription);
		$copyObj->setSheetidfk($this->sheetidfk);
		$copyObj->setTotalinamount($this->totalinamount);
		$copyObj->setTotaloutweight($this->totaloutweight);

		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getOutgoings() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addOutgoing($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getIncomings() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addIncoming($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);
		$copyObj->setOperationid(NULL); // this is a auto-increment column, so set to default value
	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Operation Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     OperationPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OperationPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Sheet object.
	 *
	 * @param      Sheet $v
	 * @return     Operation The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setSheet(Sheet $v = null)
	{
		if ($v === null) {
			$this->setSheetidfk(NULL);
		} else {
			$this->setSheetidfk($v->getSheetid());
		}

		$this->aSheet = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Sheet object, it will not be re-added.
		if ($v !== null) {
			$v->addOperation($this);
		}

		return $this;
	}


	/**
	 * Get the associated Sheet object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Sheet The associated Sheet object.
	 * @throws     PropelException
	 */
	public function getSheet(PropelPDO $con = null)
	{
		if ($this->aSheet === null && ($this->sheetidfk !== null)) {
			$this->aSheet = SheetQuery::create()->findPk($this->sheetidfk, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aSheet->addOperations($this);
			 */
		}
		return $this->aSheet;
	}

	/**
	 * Clears out the collOutgoings collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addOutgoings()
	 */
	public function clearOutgoings()
	{
		$this->collOutgoings = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collOutgoings collection.
	 *
	 * By default this just sets the collOutgoings collection to an empty array (like clearcollOutgoings());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initOutgoings()
	{
		$this->collOutgoings = new PropelObjectCollection();
		$this->collOutgoings->setModel('Outgoing');
	}

	/**
	 * Gets an array of Outgoing objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Operation is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Outgoing[] List of Outgoing objects
	 * @throws     PropelException
	 */
	public function getOutgoings($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collOutgoings || null !== $criteria) {
			if ($this->isNew() && null === $this->collOutgoings) {
				// return empty collection
				$this->initOutgoings();
			} else {
				$collOutgoings = OutgoingQuery::create(null, $criteria)
					->filterByOperation($this)
					->find($con);
				if (null !== $criteria) {
					return $collOutgoings;
				}
				$this->collOutgoings = $collOutgoings;
			}
		}
		return $this->collOutgoings;
	}

	/**
	 * Returns the number of related Outgoing objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Outgoing objects.
	 * @throws     PropelException
	 */
	public function countOutgoings(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collOutgoings || null !== $criteria) {
			if ($this->isNew() && null === $this->collOutgoings) {
				return 0;
			} else {
				$query = OutgoingQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByOperation($this)
					->count($con);
			}
		} else {
			return count($this->collOutgoings);
		}
	}

	/**
	 * Method called to associate a Outgoing object to this object
	 * through the Outgoing foreign key attribute.
	 *
	 * @param      Outgoing $l Outgoing
	 * @return     void
	 * @throws     PropelException
	 */
	public function addOutgoing(Outgoing $l)
	{
		if ($this->collOutgoings === null) {
			$this->initOutgoings();
		}
		if (!$this->collOutgoings->contains($l)) { // only add it if the **same** object is not already associated
			$this->collOutgoings[]= $l;
			$l->setOperation($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Operation is new, it will return
	 * an empty collection; or if this Operation has previously
	 * been saved, it will retrieve related Outgoings from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Operation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Outgoing[] List of Outgoing objects
	 */
	public function getOutgoingsJoinPerson($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = OutgoingQuery::create(null, $criteria);
		$query->joinWith('Person', $join_behavior);

		return $this->getOutgoings($query, $con);
	}

	/**
	 * Clears out the collIncomings collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addIncomings()
	 */
	public function clearIncomings()
	{
		$this->collIncomings = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collIncomings collection.
	 *
	 * By default this just sets the collIncomings collection to an empty array (like clearcollIncomings());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initIncomings()
	{
		$this->collIncomings = new PropelObjectCollection();
		$this->collIncomings->setModel('Incoming');
	}

	/**
	 * Gets an array of Incoming objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Operation is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Incoming[] List of Incoming objects
	 * @throws     PropelException
	 */
	public function getIncomings($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collIncomings || null !== $criteria) {
			if ($this->isNew() && null === $this->collIncomings) {
				// return empty collection
				$this->initIncomings();
			} else {
				$collIncomings = IncomingQuery::create(null, $criteria)
					->filterByOperation($this)
					->find($con);
				if (null !== $criteria) {
					return $collIncomings;
				}
				$this->collIncomings = $collIncomings;
			}
		}
		return $this->collIncomings;
	}

	/**
	 * Returns the number of related Incoming objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Incoming objects.
	 * @throws     PropelException
	 */
	public function countIncomings(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collIncomings || null !== $criteria) {
			if ($this->isNew() && null === $this->collIncomings) {
				return 0;
			} else {
				$query = IncomingQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByOperation($this)
					->count($con);
			}
		} else {
			return count($this->collIncomings);
		}
	}

	/**
	 * Method called to associate a Incoming object to this object
	 * through the Incoming foreign key attribute.
	 *
	 * @param      Incoming $l Incoming
	 * @return     void
	 * @throws     PropelException
	 */
	public function addIncoming(Incoming $l)
	{
		if ($this->collIncomings === null) {
			$this->initIncomings();
		}
		if (!$this->collIncomings->contains($l)) { // only add it if the **same** object is not already associated
			$this->collIncomings[]= $l;
			$l->setOperation($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Operation is new, it will return
	 * an empty collection; or if this Operation has previously
	 * been saved, it will retrieve related Incomings from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Operation.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Incoming[] List of Incoming objects
	 */
	public function getIncomingsJoinPerson($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = IncomingQuery::create(null, $criteria);
		$query->joinWith('Person', $join_behavior);

		return $this->getIncomings($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->operationid = null;
		$this->operationts = null;
		$this->operationdescription = null;
		$this->sheetidfk = null;
		$this->totalinamount = null;
		$this->totaloutweight = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collOutgoings) {
				foreach ((array) $this->collOutgoings as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collIncomings) {
				foreach ((array) $this->collIncomings as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collOutgoings = null;
		$this->collIncomings = null;
		$this->aSheet = null;
	}

	/**
	 * Catches calls to virtual methods
	 */
	public function __call($name, $params)
	{
		if (preg_match('/get(\w+)/', $name, $matches)) {
			$virtualColumn = $matches[1];
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
			// no lcfirst in php<5.3...
			$virtualColumn[0] = strtolower($virtualColumn[0]);
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
		}
		return parent::__call($name, $params);
	}

} // BaseOperation
