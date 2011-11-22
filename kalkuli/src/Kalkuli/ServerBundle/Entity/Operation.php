<?php

namespace Kalkuli\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Kalkuli\ServerBundle\Repository\OperationRepository")
 * @ORM\Table(name="operations",uniqueConstraints={@ORM\UniqueConstraint(name="operations_UQ_access_key",columns={"access_key"})})
 */
class Operation {
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
	 * @ORM\Column(name="description")
	 */
	protected $description;

	/**
	 * @ORM\Column(type="date", name="date")
	 */
	protected $date;

	/**
	 * @ORM\ManyToOne(targetEntity="Sheet")
	 * @ORM\JoinColumn(name="sheet_id_fk", referencedColumnName="id")
	 */
	protected $sheet;

	/**
	 * @ORM\OneToMany(targetEntity="Incoming", mappedBy="operation")
	 */
	protected $incomingList;

	/**
	* @ORM\OneToMany(targetEntity="Outgoing", mappedBy="operation")
	*/
	protected $outgoingList;
    public function __construct()
    {
        $this->incomingList = new \Doctrine\Common\Collections\ArrayCollection();
    $this->outgoingList = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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

    /**
     * Add incomingList
     *
     * @param Kalkuli\ServerBundle\Entity\Incoming $incomingList
     */
    public function addIncoming(\Kalkuli\ServerBundle\Entity\Incoming $incomingList)
    {
        $this->incomingList[] = $incomingList;
    }

    /**
     * Get incomingList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIncomingList()
    {
        return $this->incomingList;
    }

    /**
     * Add outgoingList
     *
     * @param Kalkuli\ServerBundle\Entity\Outgoing $outgoingList
     */
    public function addOutgoing(\Kalkuli\ServerBundle\Entity\Outgoing $outgoingList)
    {
        $this->outgoingList[] = $outgoingList;
    }

    /**
     * Get outgoingList
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOutgoingList()
    {
        return $this->outgoingList;
    }
}
