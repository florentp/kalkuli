<?php

namespace Kalkuli\ServerBundle\Controller;

use Kalkuli\ServerBundle\HttpUtils;
use Kalkuli\ServerBundle\KeyGenerator;

use Kalkuli\ServerBundle\Entity\Sheet;
use Kalkuli\ServerBundle\Entity\Operation;
use Kalkuli\ServerBundle\Entity\Person;
use Kalkuli\ServerBundle\Entity\Incoming;
use Kalkuli\ServerBundle\Entity\Outgoing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SheetController extends Controller {
	/**
	 * @Route("/{sheetAccessKey}.json")
	 */
	public function getSheetAction($sheetAccessKey) {
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
	 * Creates a new sheet based on the given information and returns the
	 * accessKey. An email is sent to the creatorEmail.
	 *
	 * Request example:
	 * POST /sheet/create.json
	 * {"sheet":{"name":"Holidays 2012","currencyCode":"EUR","creatorEmail":"florent.paillard&#64;gmail.com"}}
	 *
	 * @Route("/sheet/create.json")
	 */
	public function createSheetAction() {
		$createSheetCommand = HttpUtils::jsonDenormalizeRequest($this->getRequest(), 'Kalkuli\ServerBundle\Controller\Command\CreateSheetCommand', 'sheet');

		$errors = $this->get('validator')->validate($createSheetCommand);
		if (count($errors) > 0) {
			$exception = array();
			foreach ($errors as $error)
				$exception[] = $error->getMessage();
			$response = new Response(json_encode(array('exception' => $exception)), 500);
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}

		$now = new \DateTime;
		$keyGenerator = new KeyGenerator();


		$em = $this->getDoctrine()->getEntityManager();

		$em->getConnection()->beginTransaction();
		try {
			$sheet = new Sheet();
			$sheet->setAccessKey($keyGenerator->generateKey(10));
			$sheet->setName($createSheetCommand->getName());
			$sheet->setCurrencyCode($createSheetCommand->getCurrencyCode());
			$sheet->setCreatorEmail($createSheetCommand->getCreatorEmail());
			$sheet->setCreatedOn($now);
			$sheet->setLastModifiedOn($now);

			$em->persist($sheet);

			$em->flush();
			$em->getConnection()->commit();
		}
		catch (Exception $e) {
			$em->getConnection()->rollback();
			$em->close();
			throw $e;
		}

		$response = new Response(json_encode(array('sheetAccessKey' => $sheet->getAccessKey())));
		$response->headers->set("Content-Type", "application/json");
		return $response;
	}

	/**
	 * Updates sheet information. Only the sheet attributes supplied in the
	 * request. Note that accessKey is not expected in these attributes and is
	 * not modifiable.
	 *
	 * Request example:
	 * POST /5De21s4Z5/update.json
	 * {"sheet":{"name":"Holidays 2012","creatorEmail":"florent.paillard&#64;gmail.com"}}
	 *
	 * @Route("/{sheetAccessKey}/update.json")
	 */
	public function updateSheetAction($sheetAccessKey) {
		$updateSheetCommand = HttpUtils::jsonDenormalizeRequest($this->getRequest(), 'Kalkuli\ServerBundle\Controller\Command\UpdateSheetCommand', 'sheet');

		$errors = $this->get('validator')->validate($updateSheetCommand);
		if (count($errors) > 0) {
			$exception = array();
			foreach ($errors as $error)
				$exception[] = $error->getMessage();
			$response = new Response(json_encode(array('exception' => $exception)), 500);
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}

		$sheet = $this->getDoctrine()->getRepository('KalkuliServerBundle:Sheet')->findOneByAccessKey($sheetAccessKey);
		if (empty($sheet))
			throw new Exception('Sheet "' + $sheetAccessKey + '" not found.');

		$em = $this->getDoctrine()->getEntityManager();

		$em->getConnection()->beginTransaction();
		try {
			if (!\is_empty($updateSheetCommand->getName()))
				$sheet->setName($updateSheetCommand->getName());

			if (!\is_empty($updateSheetCommand->getCurrencyCode()))
			$sheet->setCurrencyCode($updateSheetCommand->getCurrencyCode());

			if (!\is_empty($updateSheetCommand->getCreatorEmail()))
				$sheet->setCreatorEmail($updateSheetCommand->getCreatorEmail());

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

