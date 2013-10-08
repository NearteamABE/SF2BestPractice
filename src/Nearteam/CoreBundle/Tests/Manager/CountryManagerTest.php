<?php

namespace Nearteam\CoreBundle\Tests\Manager;

use Nearteam\CoreBundle\Manager\CountryManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Arbi Jaafar
 */
class CountryManagerTest extends WebTestCase {

    /**
     * @var Nearteam\CoreBundle\Manager\CountryManager
     */
    private $countryManager;

    /**
     * SetUp test to boot kernel
     */
    public function setUp() {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->countryManager = $kernel->getContainer()->get('nearteam_core.manager.country');

    }

    //aj-101012
    public function testGetOneById() {
        $idCountry = 1;
        $country = $this->countryManager->getOneById($idCountry);

        $this->assertEquals(33, $country->getPhonePrefix());
    }

    //aj-101012
    public function testGetListCountries() {
        $countryList = $this->countryManager->getListCountries();

        $this->assertTrue(count($countryList) > 0);
    }



}
