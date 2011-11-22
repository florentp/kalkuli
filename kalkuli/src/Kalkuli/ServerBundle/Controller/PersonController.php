<?php

namespace Kalkuli\ServerBundle\Controller;

use Kalkuli\ServerBundle\HttpUtils;

use Kalkuli\ServerBundle\Entity\Sheet;
use Kalkuli\ServerBundle\Entity\Operation;
use Kalkuli\ServerBundle\Entity\Person;
use Kalkuli\ServerBundle\Entity\Incoming;
use Kalkuli\ServerBundle\Entity\Outgoing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PersonController extends Controller {

	/**
	 * Request example:
	 * POST /5De21s4Z5/person/add.json
	 * {"accessKey":"4dRsq854C","name":"Bob","color":"#B6E"}
	 *
	 * @Route("/{sheetAccessKey}/person/add.json")
	 */
	public function addPersonAction($sheetAccessKey) {
		$addPersonCommand = HttpUtils::deserializeRequest($this->getRequest(), 'Kalkuli\ServerBundle\Controller\Command\AddPersonCommand', 'json');

		$errors = $this->get('validator')->validate($addPersonCommand);
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
			throw new \Exception('Sheet "' + $sheetAccessKey + '" not found.');

		$em = $this->getDoctrine()->getEntityManager();

		$em->getConnection()->beginTransaction();
		try {
			$person = new Person();
			$person->setAccessKey($addPersonCommand->getAccessKey());
			$person->setName($addPersonCommand->getName());
			$person->setColor($addPersonCommand->getColor());
			$person->setBalance(0.0);
			$person->setSheet($sheet);
			$em->persist($person);

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

	/**
	 * Request example:
	 * GET /5De21s4Z5/person/list.json
	 *
	 * @Route("/{sheetAccessKey}/person/list.json")
	 */
	public function getPersonListAction($sheetAccessKey) {

		$sheet = $this->getDoctrine()->getRepository('KalkuliServerBundle:Sheet')->findOneByAccessKey($sheetAccessKey);
		if (empty($sheet))
			throw new \Exception('Sheet "' + $sheetAccessKey + '" not found.');

		$temp = $this->getDoctrine()->getRepository('KalkuliServerBundle:Person')->findBySheet($sheet->getId());
		$personList = array();
		foreach ($temp as $person) {
			$personList[] = array(
				'id' => $person->getAccessKey(),
				'name' => $person->getName(),
				'color' => $person->getColor(),
				'balance' => $person->getBalance(),
			);
		}

		$response = new Response(json_encode(array('personList' => $personList)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * Updates person information. Only the person attributes supplied in the
	 * request are updated except accessKey which is required and not
	 * modifiable.
	 *
	 * Request example:
	 * POST /5De21s4Z5/person/update.json
	 * {"accessKey":"4dRsq854C","name":"Bob"}
	 *
	 * @Route("/{sheetAccessKey}/person/update.json")
	 */
	public function updatePersonAction($sheetAccessKey) {
		$updatePersonCommand = HttpUtils::deserializeRequest($this->getRequest(), 'Kalkuli\ServerBundle\Controller\Command\UpdatePersonCommand', 'json');

		$errors = $this->get('validator')->validate($updatePersonCommand);
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
			throw new \Exception('Sheet "' + $sheetAccessKey + '" not found.');

		$person = $this->getDoctrine()->getRepository('KalkuliServerBundle:Person')->findOneByAccessKey($updatePersonCommand->getAccessKey());
		if (empty($person))
			throw new \Exception('Person "' + $updatePersonCommand->getAccessKey() + '" not found.');

		$em = $this->getDoctrine()->getEntityManager();

		$em->getConnection()->beginTransaction();
		try {
			if (!\is_empty($updatePersonCommand->getName()))
				$person->setName($updatePersonCommand->getName());

			if (!\is_empty($updatePersonCommand->getColor()))
				$person->setColor($updatePersonCommand->getColor());

			$em->persist($person);

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

