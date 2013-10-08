<?php

namespace Nearteam\UserBundle\Business;

use Nearteam\UserBundle\Entity\Subscription;

/**
 * @author HAbdellatif
 * @mail habiba.abdellatif@nearteam.fr
 */
class UserBusiness
{

    private $userManager;
	private $logManager;
	private $logger;
	private $countryManager;
	

    public function __construct($userManager, $logManager,
								$countryManager, $logger)
    {
       
        $this -> userManager = $userManager;
		$this -> logManager = $logManager;
		$this -> countryManager = $countryManager;
		$this-> logger = $logger;
    }


    /**
     * getCountUsersList : retunr a list of Users from User table
     * @param Array $filterParameters
     * @access public
     * @return object
     */
    public function getCountUsersList($filterParameters)
    {

		return $this -> userManager -> getCountUsersList($filterParameters);
    }



   
   

    /**
     * userUpdate
     * @param array $values (list of values form)
     * @param User $user
     * @param String $gender
     * @access public
     */

    /** ticket 5988 * */
   public function userUpdate($values, $user, $gender)
    {

        $criteria = array();
        $criteria['idUser'] = $user -> getIdUser();
        $idCountry = '';
        $criteria['lastName'] = '';
        $criteria['firstName'] = '';
        $criteria['email'] = '';
        $criteria['mobilePhone'] = '';
        $criteria['address'] = '';
        $criteria['zipcode'] = '';
        $criteria['gender'] = '';
        $criteria['birth_date'] = '';
		$postalCode = '';

        if (isset($values['lastName'])) {
            $criteria['lastName'] = $values['lastName'];
        }
        if (isset($values['firstName'])) {
            $criteria['firstName'] = $values['firstName'];
        }
        if (isset($values['email'])) {
            $criteria['email'] = $values['email'];
        }

		if (isset($values['phone']))
		{
        $criteria['mobilePhone'] = $values['phone'];
		}
		if (isset($values['address']))
		{
        $criteria['address'] = $values['address'];
		}
		if (isset($values[0]['gender']))
		{
		$criteria['gender'] = $values[0]['gender'];
		}
		if (isset($values[0]['country']))
		{

        $idCountry = $values[0]['country'];
		}


		if($values[1]['password']!=''){
			$password = $values[1]['password'];
			$criteria['password'] = md5('%3n!' . $password);
		}else{
			$criteria['password']='';
		}
		if (isset($values[0]['postalCode']))
		{
            $postalCode = $values[0]['postalCode'];
        }

		$day = '';
		$year = '';
		$month = '';


        if (isset($values['phone'])) {
            $criteria['mobilePhone'] = $values['phone'];
        }
        if (isset($values['address'])) {
            $criteria['address'] = $values['address'];
        }

        if (isset($values[0]['dateNaissance']['day'])) {

            $day = $values[0]['dateNaissance']['day'];
        }
        if (isset($values[0]['dateNaissance']['year'])) {
            $year = $values[0]['dateNaissance']['year'];
        }
        if (isset($values[0]['dateNaissance']['year'])) {
            $month = $values[0]['dateNaissance']['month'];
        }
       if (( (! empty($day)) and ($day != '00'))  and ( (! empty($month)) and ($month != '00'))  and (( ! empty($year))) ) {
			        $criteria['birth_date'] = $year . '-' . $month . '-' . $day;
        }

		try {
		/******** log user business ********/
		$this->logger->info('Modification user userUpdate() user='.$user -> getIdUser());
		/***********************************/
				$country = $this->countryManager -> loadOneBy(array('idCountry' => $idCountry));
				$user -> setGender($gender);
				$user -> setEmail($criteria['email']);
				$user -> setFirstName($criteria['firstName']);
				$user -> setLastName($criteria['lastName']);
				$user -> setAddress($criteria['address']);
				
				if (( (! empty($day)) and ($day != '00'))  and ( (! empty($month)) and ($month != '00'))  and (( ! empty($year))) ) {

					$user -> setBirthDate($year . "-" . $month . "-" . $day);


				}


        } catch (\Exception $e) {

           $this->logger -> err('userUpdate() error user update for id = ' . $user -> getIdUser());
        }
        $this -> userManager -> save($user);
    }

    /**
     * load
     * @param array Optin $optins
     * @param integer $identifier
     * @access public
     */
    public function load($identifier)
    {
        return $this -> userManager -> load($identifier);
    }

    
    /**
     * load all users
     * @access public
     * return User[]
     */
    public function loadAll()
    {

        return $this -> userManager -> loadAll();
    }

    /**
     * load an user
     * @param array $criteria
     * return User
     */
    public function loadOneBy($criteria)
    {

        return $this -> userManager -> loadOneBy($criteria);
    }

    /**
     * load users maching criteria
     * @param array $criteria
     * return User[]
     */
    public function loadBy($criteria)
    {

        return $this -> userManager -> loadBy($criteria);
    }

}

