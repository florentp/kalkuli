<?php

namespace Kalkuli\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Kalkuli\ServerBundle\Repository\IncomingRepository")
 * @ORM\Table(name="incomings")
 */
class Incoming {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="amount", type="float")
	 */
	protected $amount;

	/**
	 * @ORM\ManyToOne(targetEntity="Operation", inversedBy="incomingList")
	 * @ORM\JoinColumn(name="operation_id_fk", referencedColumnName="id")
	 */
	protected $operation;

	/**
	 * @ORM\ManyToOne(targetEntity="Person")
	 * @ORM\JoinColumn(name="person_id_fk", referencedColumnName="id")
	 */
	protected $person;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set operation
     *
     * @param Kalkuli\ServerBundle\Entity\Operation $operation
     */
    public function setOperation(\Kalkuli\ServerBundle\Entity\Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Get operation
     *
     * @return Kalkuli\ServerBundle\Entity\Operation 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set person
     *
     * @param Kalkuli\ServerBundle\Entity\Person $person
     */
    public function setPerson(\Kalkuli\ServerBundle\Entity\Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get person
     *
     * @return Kalkuli\ServerBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}