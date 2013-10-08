<?php

namespace Nearteam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Nearteam\CoreBundle\Entity\Core\Country
 *
 * @ORM\Table(name="country",indexes={@ORM\Index(name="country_visibility_idx", columns={"visibility"})})
 * @ORM\Entity
 */
class Country
{

    /**
     * @var integer $idCountry
     *
     * @ORM\Id
     * @ORM\Column(name="id_country", columnDefinition="INTEGER UNSIGNED NOT NULL")
     */
    private $idCountry;

    /**
     * @var string $iso
     *
     * @ORM\Column(name="iso", type="string", length=2, nullable=true)
     */
    private $iso;

    /**
     * @var string $iso
     *
     * @ORM\Column(name="iso3", type="string", length=3, nullable=true)
     */
    private $iso3;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string $postalCodeRegexp
     *
     * @ORM\Column(name="postal_code_regexp", type="string", length=255, nullable=true)
     */
    private $postalCodeRegexp;

    /**
     * @var integer $phonePrefix
     *
     * @ORM\Column(name="phone_prefix", type="integer", nullable=true)
     */
    private $phonePrefix;

    /**
     * @var boolean $visibility
     *
     * @ORM\Column(name="visibility", type="boolean", nullable=true)
     */
    private $visibility;

    

    /**
     * @var integer $phoneRegexp
     *
     * @ORM\Column(name="phone_regexp", type="string", length=255, nullable=true)
     */
    private $phoneRegexp;

   

    public function __construct()
    {
        $this->visibility = false;
    }

    /**
     * Set idCountry
     *
     * @param string $idCountry
     */
    public function setIdCountry($idCountry)
    {
        $this->idCountry = $idCountry;
    }

    /**
     * Get idCountry
     *
     * @return string 
     */
    public function getIdCountry()
    {
        return $this->idCountry;
    }

    /**
     * Set iso
     *
     * @param string $iso
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    }

    /**
     * Get iso
     *
     * @return string 
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * Set iso3
     *
     * @param string $iso3
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;
    }

    /**
     * Get iso3
     *
     * @return string 
     */
    public function getIso3()
    {
        return $this->iso3;
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
     * Set postalCodeRegexp
     *
     * @param string $postalCodeRegexp
     */
    public function setPostalCodeRegexp($postalCodeRegexp)
    {
        $this->postalCodeRegexp = $postalCodeRegexp;
    }

    /**
     * Get postalCodeRegexp
     *
     * @return string 
     */
    public function getPostalCodeRegexp()
    {
        return $this->postalCodeRegexp;
    }

    /**
     * Set phonePrefix
     *
     * @param integer $phonePrefix
     */
    public function setPhonePrefix($phonePrefix)
    {
        $this->phonePrefix = $phonePrefix;
    }

    /**
     * Get phonePrefix
     *
     * @return integer 
     */
    public function getPhonePrefix()
    {
        return $this->phonePrefix;
    }

    /**
     * Set visibility
     *
     * @param boolean $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Get visibility
     *
     * @return boolean 
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set phoneRegexp
     *
     * @param string $phoneRegexp
     */
    public function setPhoneRegexp($phoneRegexp)
    {
        $this->phoneRegexp = $phoneRegexp;
    }

    /**
     * Get phoneRegexp
     *
     * @return string 
     */
    public function getPhoneRegexp()
    {
        return $this->phoneRegexp;
    }
}