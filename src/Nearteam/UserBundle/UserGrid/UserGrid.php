<?php

namespace Nearteam\UserBundle\UserGrid;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Service for users grid configuration
 */
class UserGrid
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

	 /**
     * get search values from search User Form
	 * @author BEN. Y.
     */
    public function getParameters($filterParameters)
    {
		$mail = (string) $filterParameters['email'];
        $firstName = (string) $filterParameters['firstName'];
        $lastName = (string) $filterParameters['lastName'];
        $cp = (string) $filterParameters['cp'];
        $idUser = (string) $filterParameters['idUser'];
        $phoneNumber = (string) $filterParameters['phone'];
		$country = (string) $filterParameters['country'];
		$token = (string) $filterParameters['_token'];
        $mail = $this->request->getSession()->set('user_email', $mail);
        $this->request->getSession()->set('user_firstName', $firstName);
        $this->request->getSession()->set('user_lastName', $lastName);
        $this->request->getSession()->set('user_cp', $cp);
  		$this->request->getSession()->set('user_idUser', $idUser);
        $this->request->getSession()->set('user_phone', $phoneNumber);
        $this->request->getSession()->set('user_country', $country);
		$this->request->getSession()->set('user_token', $token);
    }
	
	 /**
     * apply the filter of parameters to the grid list users
	 * @author ABD. H.
     */

    public function getFilterParameters()
    {

        $mail = $this->request->getSession()->get('user_email', '');
        $firstName = $this->request->getSession()->get('user_firstName', '');
        $lastName = $this->request->getSession()->get('user_lastName', '');
        $cp = $this->request->getSession()->get('user_cp', '');
        $city = $this->request->getSession()->get('user_city', '');
        $idUser = $this->request->getSession()->get('user_idUser', '');
        $phoneNumber = $this->request->getSession()->get('user_phone', '');
        $marque = $this->request->getSession()->get('user_country', '');
        $filters = array ();
        $filters['groupOp'] = "AND";
        $filters['rules'] = array ();

        if (!empty($mail)) {
            $filters['rules'] [] = array ("field" => "c.email", "op" => "cn", "data" => $mail);
        }

        if (!empty($lastName)) {
            $filters['rules'] [] = array ("field" => "c.lastName", "op" => "cn", "data" => $lastName);
        }

        if (!empty($firstName)) {
            $filters['rules'] [] = array ("field" => "c.firstName", "op" => "eq", "data" => $firstName);
        }

        if (!empty($cp)) {
            $filters['rules'] [] = array ("field" => "c.cp", "op" => "cn", "data" => $cp);
        }

        if (!empty($idUser)) {
            $filters['rules'] [] = array ("field" => "c.idUser", "op" => "cn", "data" => $idUser);
        }

        
		if((!(empty($phoneNumber))))
		 { 
			$phone = $phoneCode.'-'.$phoneNumber;
			$filters['rules'] [] = array("field" => "c.phone", "op" => "cn", "data" => $phone);
		 }
		 
        if (!empty($country)) {
            $filters['rules'] [] = array ("field" => "cn.idCountry", "op" => "eq", "data" => $country);
        }


        $filters = json_encode($filters);

        $this->request->query->set('_search', true);
        $this->request->query->set('filters', $filters);
		
		
    }

}