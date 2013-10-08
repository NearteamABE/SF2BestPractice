<?php

namespace Nearteam\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nearteam\UserBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="Nearteam\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{

    const ACCOUNT_TYPE_COLLECT = 'COLLECT';
    const ACCOUNT_TYPE_MEMBER = 'MEMBER';
    const ACCOUNT_TYPE_BLACKLISTED = 'BLACKLISTED';
    const ACCOUNT_TYPE_DISABLED = 'DISABLED';

    /**
     * @ORM\Id
     * @ORM\Column(name="id_user", columnDefinition="INT UNSIGNED NOT NULL")
     */
    private $idUser;

    /**
     *
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP NULL",name="create_dt")
     */
    private $createDt;

    /**
     *
     * @ORM\Column(type="string",name="first_name", length="255", nullable=true)
     */
    private $firstName;

    /**
     *
     * @ORM\Column(type="string",name="last_name", length="255", nullable=true)
     */
    private $lastName;

    /**
     *
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP NULL",name="update_dt")
     */
    private $updateDt;

    /**
     *
     * @ORM\Column(type="boolean",name="is_deleted")
     */
    private $isDeleted = 0;

    /**
     *
     * @ORM\Column(columnDefinition="DATE NULL",name="birth_date")
     */
    private $birthDate;

    /**
     *
     * @ORM\Column(type="string",name="email",nullable="true")
     */
    private $email;

    /**
     *
     * @ORM\Column(type="boolean",name="is_vip",nullable="true")
     */
    private $isVIP;

    /**
     *
     * @ORM\Column(type="string",name="phone", nullable=true)
     */
    private $phone;

	/**
     *
     * @ORM\Column(type="string",name="cp", nullable=true)
     */
    private $cp;

    /**
     *
     * @ORM\Column(type="string", name="mobile_phone", nullable=true)
     */
    private $mobilePhone;

    /**
     *
     * @ORM\Column(type="string",name="address",nullable="true")
     */
    private $address;

    /**
     * @var String $gender
     * @ORM\Column(name="gender", type="string", columnDefinition="ENUM('M', 'F')")
     */
    private $gender;

    /**
     *
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP NULL",name="delete_dt")
     */
    private $deleteDt;

    

    /**
     * var string $accountType
     * @ORM\Column(type="string",name="account_type",nullable="true")
     */
    private $accountType;
	
	/**
     * @var Country $country
     * @ORM\ManyToOne(targetEntity="Nearteam\CoreBundle\Entity\Country")
     * @ORM\JoinColumn(name="id_country", referencedColumnName="id_country", columnDefinition="INT UNSIGNED NOT NULL")
     */
    private $country;

   

    /**
     * Constructor
     */
    public function __construct()
    {
    }


    /**
     * Set idUser
     *
     * @param string $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * Get idUser
     *
     * @return string 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set createDt
     *
     * @param datetime $createDt
     */
    public function setCreateDt($createDt)
    {
        $this->createDt = $createDt;
    }

    /**
     * Get createDt
     *
     * @return datetime 
     */
    public function getCreateDt()
    {
        return $this->createDt;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set updateDt
     *
     * @param datetime $updateDt
     */
    public function setUpdateDt($updateDt)
    {
        $this->updateDt = $updateDt;
    }

    /**
     * Get updateDt
     *
     * @return datetime 
     */
    public function getUpdateDt()
    {
        return $this->updateDt;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * Get isDeleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set birthDate
     *
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * Get birthDate
     *
     * @return string 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isVIP
     *
     * @param boolean $isVIP
     */
    public function setIsVIP($isVIP)
    {
        $this->isVIP = $isVIP;
    }

    /**
     * Get isVIP
     *
     * @return boolean 
     */
    public function getIsVIP()
    {
        return $this->isVIP;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set cp
     *
     * @param string $cp
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * Get mobilePhone
     *
     * @return string 
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set deleteDt
     *
     * @param datetime $deleteDt
     */
    public function setDeleteDt($deleteDt)
    {
        $this->deleteDt = $deleteDt;
    }

    /**
     * Get deleteDt
     *
     * @return datetime 
     */
    public function getDeleteDt()
    {
        return $this->deleteDt;
    }

    /**
     * Set accountType
     *
     * @param string $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * Get accountType
     *
     * @return string 
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Set country
     *
     * @param Nearteam\CoreBundle\Entity\Country $country
     */
    public function setCountry(\Nearteam\CoreBundle\Entity\Country $country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return Nearteam\CoreBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
	
	/**
     * Serialise an object properties
     *
     * @return string $entityProperties
     */
    function serialise()
    {   
	
	    $firstName = '';
        $lastName = '';
        $gender = '';
        $email = '';
        $isVIP = '';
        $phone = '';
        $mobilePhone = '';
		$country='';

	    if (($this->country) != null) {
		    $country = $this->country->getName();
		}
        $listSerialise = array ("idUser" => $this->idUser, 'createDt' => $this->createDt, 'firstName' => $this->firstName,
            'lastName' => $this->lastName, 'updateDt' => $this->updateDt, 'isDeleted' => $this->isDeleted, 'birthDate' => $this->birthDate,
            'gender' => $this->gender, 'email' => $this->email, 'isVIP' => $this->isVIP, 'phone' => $this->phone, 'deleteDt' => $this->deleteDt,
            'mobilePhone' => $this->mobilePhone, 'address' => $this->address,
            'country' => $country
        );

        return json_encode($listSerialise);
    }

    /**
     * Deserialise an object properties
     *
     * @param string $jsonEcodedEntity
     * @return object $object
     */
    function deserialise($jsonEcodedEntity)
    {

        return true;
    }
}