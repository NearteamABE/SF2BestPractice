<?php

namespace Nearteam\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Nearteam\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

		$createDT = new \DateTime('2012-07-19 05:00:00');
        $updateDT = new \DateTime('2012-07-20 05:00:00');
        $deleteDT = new \DateTime('2012-07-17 05:00:00');
        $birthDT = new \DateTime('1986-05-17 05:00:00');

        $user1 = new User();
        $user1 -> setIdUser(1);
        $user1 -> setFirstName('Amir');
        $user1 -> setLastName('Sghair');
        $user1 -> setEmail('admin@admin.com');
        $user1 -> setCreateDt($createDT);
        $user1 -> setUpdateDt($updateDT);
        $user1 -> setDeleteDt($deleteDT);
        $user1 -> setBirthDate('1986-05-17 05:00:00');
		$user1 -> setGender('M');
        $user1 -> setPhone(36598745);
        $user1 -> setIsVIP(true);
        $user1 -> setMobilePhone(36598745);
        $user1 -> setAddress('20 rue du Sentier');
        $user1 -> setIsDeleted(false);
		$user1 -> setCountry($manager -> merge($this -> getReference('country-1')));

		$user2 = new user();
        $user2 -> setIduser(2);
        $user2 -> setFirstName('Habiba');
        $user2 -> setLastName('Abdellatif');
        $user2 -> setEmail('Habiba@Nearteam.fr');
        $user2 -> setCreateDt($createDT);
        $user2 -> setUpdateDt($updateDT);
        $user2 -> setDeleteDt($deleteDT);
        $user2 -> setBirthDate('1986-05-17 05:00:00');
		$user2 -> setGender('F');
        $user2 -> setPhone(32564888);
        $user2 -> setIsVIP(true);
        $user2 -> setMobilePhone(32564888);
        $user2 -> setAddress('20 rue du Sentier');
        $user2 -> setIsDeleted(false);
		$user2 -> setCountry($manager -> merge($this -> getReference('country-2')));

		
        $manager -> persist($user1);
		$manager -> persist($user2);

        $manager -> flush();

        $this -> addReference('user-1', $user1);
		$this -> addReference('user-2', $user2);

    }

    public function getOrder()
    {
        return 2;
    }

}