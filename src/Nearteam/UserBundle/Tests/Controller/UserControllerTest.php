<?php

namespace Nearteam\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    /**
     * Test userList method
     */
    public function testUserList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/user_list');
        $this->assertTrue($crawler->filter('html:contains("2 results maching your criteria")')->count() > 0);
    }

    public function testSearchUser()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/search_form_user');
        $this->assertTrue($crawler->filter('html:contains("Filtrer")')->count() > 0);
    }

    public function testgetInfosUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/infos_user/1');
        $this->assertTrue($crawler->filter('html:contains("Amir")')->count() > 0);
    }

    public function testEditUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/edit_user/1');
        $this->assertTrue($crawler->filter('html:contains("admin@admin.com")')->count() > 0);
    }

}
