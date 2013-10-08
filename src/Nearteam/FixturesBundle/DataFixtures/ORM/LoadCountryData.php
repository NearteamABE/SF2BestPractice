<?php

namespace Nearteam\FixturesBundle\DataFixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Nearteam\CoreBundle\Entity\Country;

class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

		// (1,'','','^(d{5})$',33,0,'','France'),
		$country1 = new Country();
		$country1 -> setIdCountry(1);
		$country1 -> setIso("");
		$country1 -> setIso3("");
        $country1 -> setPostalCodeRegexp('^(d{5})$');
        $country1 -> setPhonePrefix(33);
		$country1 -> setVisibility(0);
		$country1 -> setPhoneRegexp('');
		$country1 -> setName('France');
		
		// (2,'','','^(d{5})$',27,0,'','Espagne'),
		$country2 = new Country();
		$country2 -> setIdCountry(2);
		$country2 -> setIso("");
		$country2 -> setIso3("");
        $country2 -> setPostalCodeRegexp('^(d{4})$');
        $country2 -> setPhonePrefix(27);
		$country2 -> setVisibility(0);
		$country2 -> setPhoneRegexp('');
		$country2 -> setName('Espagne');
		
		// (3,'','','',355,0,'','Suisse'),
		$country3 = new Country();
		$country3 -> setIdCountry(3);
		$country3 -> setIso("");
		$country3 -> setIso3("");
        $country3 -> setPostalCodeRegexp('');
        $country3 -> setPhonePrefix(355);
		$country3 -> setVisibility(0);
		$country3 -> setPhoneRegexp('');
		$country3 -> setName('Suisse');
		
		// (4,'','','^(d{5})$',213,0,'','Afrique du Sud'),
		$country4 = new Country();
		$country4 -> setIdCountry(4);
		$country4 -> setIso("");
		$country4 -> setIso3("");
        $country4 -> setPostalCodeRegexp('^(d{5})$');
        $country4 -> setPhonePrefix(213);
		$country4 -> setVisibility(0);
		$country4 -> setPhoneRegexp('');
		$country4 -> setName('Afrique du Sud');
		
		// (5,'','','^(d{5})$',49,0,'','Albanie'),
		$country5 = new Country();
		$country5 -> setIdCountry(5);
		$country5 -> setIso("");
		$country5 -> setIso3("");
        $country5 -> setPostalCodeRegexp('^(d{5})$');
        $country5 -> setPhonePrefix(49);
		$country5 -> setVisibility(0);
		$country5 -> setPhoneRegexp('');
		$country5 -> setName('Albanie');
		
		// (6,'','','^(?:AD)*(d{3})$',376,0,'','Algérie'),
		$country6 = new Country();
		$country6 -> setIdCountry(6);
		$country6 -> setIso("");
		$country6 -> setIso3("");
        $country6 -> setPostalCodeRegexp('^(?:AD)*(d{3})$');
        $country6 -> setPhonePrefix(376);
		$country6 -> setVisibility(0);
		$country6 -> setPhoneRegexp('');
		$country6 -> setName('Algérie');
		
		// (7,'','','',244,0,'','Allmagne'),
		$country7 = new Country();
		$country7 -> setIdCountry(7);
		$country7 -> setIso("");
		$country7 -> setIso3("");
        $country7 -> setPostalCodeRegexp('');
        $country7 -> setPhonePrefix(244);
		$country7 -> setVisibility(0);
		$country7 -> setPhoneRegexp('');
		$country7 -> setName('Allmagne');
		
		// (8,'','','',0,0,'','Andorre'),
		$country8 = new Country();
		$country8 -> setIdCountry(8);
		$country8 -> setIso("");
		$country8 -> setIso3("");
        $country8 -> setPostalCodeRegexp('');
        $country8 -> setPhonePrefix(0);
		$country8 -> setVisibility(0);
		$country8 -> setPhoneRegexp('');
		$country8 -> setName('Andorre');
		
		// (9,'','','',672,0,'','Angola'),
		$country9 = new Country();
		$country9 -> setIdCountry(9);
		$country9 -> setIso("");
		$country9 -> setIso3("");
        $country9 -> setPostalCodeRegexp('');
        $country9 -> setPhonePrefix(672);
		$country9 -> setVisibility(0);
		$country9 -> setPhoneRegexp('');
		$country9 -> setName('Angola');
		
		// (10,'','','',0,0,'','Anguila'),
		$country10 = new Country();
		$country10 -> setIdCountry(10);
		$country10 -> setIso("");
		$country10 -> setIso3("");
        $country10 -> setPostalCodeRegexp('');
        $country10 -> setPhonePrefix(0);
		$country10 -> setVisibility(0);
		$country10 -> setPhoneRegexp('');
		$country10 -> setName('Anguila');
		
		
		
		//////////////////////////////////// data persistance//////////////////////////////////////////////////////////////////////////////////////
		

        $manager->persist($country1);
        $manager->persist($country2);
        $manager->persist($country3);
		$manager->persist($country4);
        $manager->persist($country5);
        $manager->persist($country6);
		$manager->persist($country7);
        $manager->persist($country8);
        $manager->persist($country9);
		$manager->persist($country10);
    
		$manager->flush();
		

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	
		 
		 
        $this->addReference('country-1', $country1);
        $this->addReference('country-2', $country2);
        $this->addReference('country-3', $country3);
		$this->addReference('country-4', $country4);
        $this->addReference('country-5', $country5);
        $this->addReference('country-6', $country6);
		$this->addReference('country-7', $country7);
        $this->addReference('country-8', $country8);
        $this->addReference('country-9', $country9);
		$this->addReference('country-10', $country10);
    }

    public function getOrder()
    {
        return 1;
    }

}