<?php

namespace Kalkuli\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Kalkuli\ServerBundle\Repository\SheetRepository")
 * @ORM\Table(name="sheets",uniqueConstraints={@ORM\UniqueConstraint(name="sheets_UQ_access_key",columns={"access_key"})})
 */
class Sheet {
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
	 * @ORM\Column(name="currency_code")
	 */
	protected $currencyCode;

	/**
	 * @ORM\Column(name="creator_email")
	 */
	protected $creatorEmail;

	/**
	 * @ORM\Column(type="datetime", name="created_on")
	 */
	protected $createdOn;

	/**
	 * @ORM\Column(type="datetime", name="last_modified_on")
	 */
	protected $lastModifiedOn;

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
     * Set currencyCode
     *
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * Get currencyCode
     *
     * @return string 
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Set creatorEmail
     *
     * @param string $creatorEmail
     */
    public function setCreatorEmail($creatorEmail)
    {
        $this->creatorEmail = $creatorEmail;
    }

    /**
     * Get creatorEmail
     *
     * @return string 
     */
    public function getCreatorEmail()
    {
        return $this->creatorEmail;
    }

    /**
     * Set createdOn
     *
     * @param date $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * Get createdOn
     *
     * @return date 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set lastModifiedOn
     *
     * @param date $lastModifiedOn
     */
    public function setLastModifiedOn($lastModifiedOn)
    {
        $this->lastModifiedOn = $lastModifiedOn;
    }

    /**
     * Get lastModifiedOn
     *
     * @return date 
     */
    public function getLastModifiedOn()
    {
        return $this->lastModifiedOn;
    }
}