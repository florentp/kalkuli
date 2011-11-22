<?php

namespace Kalkuli\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Kalkuli\ServerBundle\Repository\OutgoingRepository")
 * @ORM\Table(name="outgoings")
 */
class Outgoing {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="float", name="weight")
	 */
	protected $weight;

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
     * Set weight
     *
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
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