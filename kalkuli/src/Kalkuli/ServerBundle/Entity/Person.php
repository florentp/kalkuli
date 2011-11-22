<?php

namespace Kalkuli\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Kalkuli\ServerBundle\Repository\PersonRepository")
 * @ORM\Table(name="people",uniqueConstraints={@ORM\UniqueConstraint(name="people_UQ_access_key",columns={"access_key"})})
 */
class Person {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(length=10, name="access_key")
	 */
	protected $accessKey;

	/**
	 * @ORM\Column(name="name")
	 */
	protected $name;

	/**
	 * @ORM\Column(name="color")
	 */
	protected $color;

	/**
	 * @ORM\Column(type="float", name="balance")
	 */
	protected $balance;

	/**
	 * @ORM\ManyToOne(targetEntity="Sheet")
	 * @ORM\JoinColumn(name="sheet_id_fk", referencedColumnName="id")
	 */
	protected $sheet;


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
     * Set accessKey
     *
     * @param string $accessKey
     */
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
    }

    /**
     * Get accessKey
     *
     * @return string 
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set color
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set balance
     *
     * @param float $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * Get balance
     *
     * @return float 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set sheet
     *
     * @param Kalkuli\ServerBundle\Entity\Sheet $sheet
     */
    public function setSheet(\Kalkuli\ServerBundle\Entity\Sheet $sheet)
    {
        $this->sheet = $sheet;
    }

    /**
     * Get sheet
     *
     * @return Kalkuli\ServerBundle\Entity\Sheet 
     */
    public function getSheet()
    {
        return $this->sheet;
    }
}
