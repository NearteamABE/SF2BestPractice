<?php

namespace Nearteam\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Nearteam\CoreBundle\Manager\Doctrine\AbstractManager;

/**
 * @author HAbdellatif
 * @mail habiba.abdellatif@nearteam.fr
 */
class UserManager extends AbstractManager
{

    public function __construct(EntityManager $em, $entityClassName)
    {

        parent::__construct($em, $entityClassName);
    }


    /**
     * getCountUsersList : retunr a list of User from User table
     * @param Array $filterParameters
     * @access public
     * @return object
     */
    public function getCountUsersList($filterParameters)
    {

		$mail = (string) $filterParameters['mail'];
        $firstName = (string) $filterParameters['firstName'];
        $lastName = (string) $filterParameters['lastName'];
        $cp = (string) $filterParameters['cp'];
        $idUser = (String) $filterParameters['idUser'];
        $phoneNumber = (int) $filterParameters['phone'];
        $country = (int) $filterParameters['country'];
        $qb = $this->em->createQueryBuilder()
                ->from('NearteamUserBundle:User', 'c')
                ->leftJoin('c.country', 'cnt') 
                ->select('c.idUser,c.firstName, c.lastName, c.email, c.createDt,c.updateDt,c.birthDate, c.phone, c.cp,cnt.name')
                ->where('c.isDeleted = false');
        if (!(empty($mail))) {
            $qb->andwhere('c.email LIKE :email')
                    ->setParameter('email', '%' . $mail . '%');
        }
		
		 if((!(empty($phoneNumber))))
		 {  
			$qb->andwhere('c.phone LIKE :phone')
               ->setParameter('phone', '%'.$phoneNumber.'%');
			
		 }

        if (!(empty($firstName))) {

            $qb->andwhere('c.firstName =  :firstName');

            $qb->setParameter('firstName', $firstName);
        }

        if (!(empty($lastName))) {

            $qb->andwhere('c.lastName LIKE :lastName');
            $qb->setParameter('lastName', '%' . $lastName . '%');
        }


        // if (!(empty($city))) {

            // $qb->andwhere('ct.idCity =  :city');
            // $qb->setParameter('city', $city);
        // }

        if (!(empty($idUser))) {

            $qb->andwhere('c.idUser LIKE :idUser');

            $qb->setParameter('idUser', '%' . $idUser . '%');
        }

    
        


        if (!(empty($country))) {


            $qb->andwhere('cnt.idCountry =  :country');

            $qb->setParameter('country', $country);
        }

        $qb->groupBy('c.idUser');
      
        return $qb;
		
    }

   

    /**
     * Get logs list ordred by creted date
     * @pram criteria[]
     * @pram order[]
     * @return LogContract[]
     */
    public function loadByOrder($criteria = array (), $order = array ())
    {
        
        return $this->repository->findBy($criteria, $order);
    }
	
	/**
     * delete  user
     * @param User $user
     */
    public function deleteUser($user)
    {

       $user->setIsDeleted(true);
	   $this -> em -> persist($user);
	   $this -> em -> flush($user);
    }

}

