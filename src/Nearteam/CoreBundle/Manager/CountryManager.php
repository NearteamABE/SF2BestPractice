<?php

namespace Nearteam\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;
use Nearteam\CoreBundle\Manager\Doctrine\AbstractManager;
use Nearteam\CoreBundle\Entity\Country;

/**
 * CountryManager
 * 
 * @author dginat
 */
class CountryManager extends AbstractManager {

    

    public function __construct(EntityManager $em, $class) {
        parent::__construct($em, $class);
    }

    /**
     * Get Country by idCountry
     * 
     * @param integer $idCountry
     * @return Country
     */
    public function getOneById($idCountry) {

        return parent::loadOneBy(array('idCountry' => $idCountry));
    }

    /**
     * Get all Countries 
     * 
     * @return Countries
     */
    public function getListCountries() {

		
		return parent::loadAll();
    }

    public function loadTranslatedCountry($country, $local) {

        $translatedCountry = $this->em->getRepository($country->getEntityTranslationClass())->findOneBy(array('idObject' => $country->getIdCountry(), 'idLocale' => $local->getIdLocale()));

        return $translatedCountry;
    }

    /**
     * Finds list of locales
     *
     * @return Locale[]
     */
    public function loadAllByLocale($locale) {

        return $this->countryTranslationRepository->findBy(array('idLocale' => $locale));
    }

}
