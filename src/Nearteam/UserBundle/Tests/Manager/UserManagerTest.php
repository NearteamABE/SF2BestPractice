<?php

namespace Nearteam\UserBundle\Tests\Manager;

use Nearteam\UserBundle\Business;
use Nearteam\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * UserManagerTest
 */
class UserManagerTest extends WebTestCase
{

    /**
     * @var Nearteam\UserBundle\Manager\UserManager
     */
    private $userManager;

    /**
     * SetUp test to boot kernel
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $this->userManager = $kernel->getContainer()
                ->get('nearteam_user.manager.user');
    }

    /**
     * Test testGetUsersList method
     */
    public function testGetUsersList()
    {

        $users = $this->userManager->getUsersList(0, 5, 1);
        $users = $users->getQuery()->getResult();
        $this->assertTrue(count($users) > 0);
    }

    /**
     * Test testGetCountUsersList method
     */
    public function testGetCountUsersList()
    {
        $creteria = array('mail' => 'Florence@Bost.com',
            'firstName' => 'Florence',
            'lastName' => 'Bost',
            'cp' => 5400,
            'iduser' => 49,
            'phone' => 12547363,
            'country' => 1);
        $users = $this->userManager->getCountUsersList($creteria);
        $users = $users->getQuery()->getResult();
        $this->assertTrue(count($users) < 2);
    }

   
}