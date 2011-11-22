<?php

namespace Kalkuli\ServerBundle\Controller;

use Kalkuli\ServerBundle\Entity\Sheet;
use Kalkuli\ServerBundle\Entity\Operation;
use Kalkuli\ServerBundle\Entity\Person;
use Kalkuli\ServerBundle\Entity\Incoming;
use Kalkuli\ServerBundle\Entity\Outgoing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

	/**
	 * @Route("/{sheetAccessKey}.json")
	 */
	public function sheetAction($sheetAccessKey) {
		$sheet = $this->getDoctrine()->getRepository('KalkuliServerBundle:Sheet')->findOneByAccessKey($sheetAccessKey);
		if (empty($sheet))
			throw new Exception('Sheet "' + $sheetAccessKey + '" not found.');

		$response = new Response(json_encode(array(
			'accessKey' => $sheet->getAccessKey(),
			'name' => $sheet->getName(),
			'currencyCode' => $sheet->getCurrencyCode(),
			'creatorEmail' => $sheet->getCreatorEmail(),
			'createdOn' => $sheet->getCreatedOn()->getTimestamp(),
			'lastModifiedOn' => $sheet->getLastModifiedOn()->getTimestamp(),
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}


	/**
	 * Request example:
	 * POST /5De21s4Z5/operation/add.json
	 * {"accessKey":"ds25E8Fsd9","description":"Billets de train","date":1321747200,"payers":[{"accessKey":"4dRsq854C","amount":10.0}],"participants":[{"accessKey":"4dRsq854C","weight":1.0},{"accessKey":"gT4Vc58Zdq","weight":1.0},{"accessKey":"0eEsd36CXs","weight":1.0}]}
	 *
	 * @Route("/{sheetAccessKey}/operation/add.json")
	 */
	public function addOperationAction($sheetAccessKey) {
		$operationData = json_decode($this->getRequest()->getContent(), true);

		$em = $this->getDoctrine()->getEntityManager();

		$sheet = $this->getDoctrine()->getRepository('KalkuliServerBundle:Sheet')->findOneByAccessKey($sheetAccessKey);

		$em->getConnection()->beginTransaction();
		try {
			$operation = new Operation();
			$operation->setAccessKey($operationData['accessKey']);
			$operation->setDescription($operationData['description']);
			$date = new \DateTime;
			$date->setTimestamp($operationData['date']);
			$operation->setDate($date);
			$operation->setSheet($sheet);
			$em->persist($operation);

			foreach ($operationData['payers'] as $payerData) {
				$payer = $this->getDoctrine()->getRepository('KalkuliServerBundle:Person')->findOneByAccessKey($payerData['accessKey']);
				$incoming = new Incoming();
				$incoming->setAmount($payerData['amount']);
				$incoming->setOperation($operation);
				$incoming->setPerson($payer);
				$operation->addIncomingList($incoming);
				$em->persist($incoming);
			}

			foreach ($operationData['participants'] as $participantData) {
				$participant = $this->getDoctrine()->getRepository('KalkuliServerBundle:Person')->findOneByAccessKey($participantData['accessKey']);
				$outgoing = new Outgoing();
				$outgoing->setWeight($participantData['weight']);
				$outgoing->setOperation($operation);
				$outgoing->setPerson($participant);
				$operation->addOutgoing($outgoing);
				$em->persist($outgoing);
			}

			$sheet->setLastModifiedOn(new \DateTime);
			$em->persist($sheet);

			$em->flush();
			$em->getConnection()->commit();
		}
		catch (Exception $e) {
			$em->getConnection()->rollback();
			$em->close();
			throw $e;
		}

		return new Response();
	}
}

