<?php



/**
 * Skeleton subclass for performing query and update operations on the 'operation' table.
 *
 * List of operations (made of incomings and outgoings)
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class OperationQuery extends BaseOperationQuery {

	public function getWeightedOperationList() {
		$con = Propel::getConnection(BookPeer::DATABASE_NAME);
		$sql = 
			"SELECT operation.*, (totalInAmount / totalOutWeight) weightedAmount
			FROM operation
			JOIN (
					SELECT operationIdFK , SUM ( inAmount ) totalInAmount
					FROM incoming
					GROUP BY operationIdFK
				) operationTotalAmount
				ON operationTotalAmount.operationIdFK = operation.operationId
			JOIN (
					SELECT operationIdFK , SUM ( outWeight ) totalOutWeight
					FROM outgoing
					GROUP BY operationIdFK
				) operationTotalWeight
				ON operationTotalWeight.operationIdFK = operation.operationId";
		$stmt = $con->prepare($sql);
		$stmt->execute();
	}

} // OperationQuery
