<?php

namespace Nearteam\UserBundle\Controller;

use Nearteam\CoreBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use EPS\JqGridBundle\Grid\Grid;
use Nearteam\UserBundle\Form\EditUser;
use Nearteam\UserBundle\Form\PasswordType;
use Nearteam\UserBundle\Form\UserSearchType;
use Nearteam\UserBundle\Form\UserType;
use Nearteam\UserBundle\Entity\User;
use Nearteam\UserBundle\Entity\Subscription;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    /**
     * show the grid list of users
     * @author ABD. H.
     */
    public function userListAction()
    {
        $request = $this -> container -> get('request');
        $countryManager = $this -> container -> get('nearteam_core.manager.country');
        $countries = $countryManager -> loadAll();
        $userBusiness = $this -> container -> get('nearteam_user.business.user');
        $data = $this -> listDataSearch();
        $qb = $userBusiness -> getCountUsersList($data);
        $grid = $this -> container -> get('eps_jq_grid');

        //OPTIONAL
        $grid -> setName('gridpost');
        $grid -> setCaption('list of posts');
        $grid -> setOptions(array('height' => 'auto', 'margin-left' => '20', 'margin-right' => '20', 'rowList' => array(10, 20, 50, 100)));
        $grid -> setRouteForced($this -> container -> get('router') -> generate('nearteam_user_viewgrid_user'));
        $grid -> setHideIfEmpty(false);

        //MANDATORY
        $grid -> setSource($qb);
        //COLUMNS DEFINITION
        /* ticket 6266  modified by ABD. Habiba */
        $grid -> addColumn($this -> container -> get('translator') -> trans('user.grid'), array('twig' => 'NearteamUserBundle:User:user.html.twig', 'index' => 'c.idUser', 'name' => 'c.idUser', 'resize' => false, 'sortable' => true, 'search' => false, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('coordonnees.grid'), array('twig' => 'NearteamUserBundle:User:coordonne.html.twig', 'name' => 'c.email', 'index' => 'c.email', 'resize' => false, 'sortable' => true, 'search' => false, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('mdp.grid'), array('twig' => 'NearteamUserBundle:User:password.html.twig', 'name' => 'password', 'resize' => false, 'sortable' => false, 'search' => false, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('codepostal.grid'), array('name' => 'cp', 'index' => 'c.cp', 'align' => 'center', 'stype' => 'select', 'search' => true, 'sortable' => true, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('dates.grid'), array('twig' => 'NearteamUserBundle:User:dates.html.twig', 'index' => 'c.updateDt', 'name' => 'c.updateDt', 'resize' => false, 'sortable' => true, 'search' => false, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('email.grid'), array('name' => 'email', 'index' => 'c.email', 'hidden' => true, 'stype' => 'select', 'search' => true, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('phone.grid'), array('name' => 'phone', 'index' => 'c.phone', 'align' => 'center', 'hidden' => true, 'stype' => 'select', 'search' => true, 'title' => false));
        $grid -> addColumn($this -> container -> get('translator') -> trans('localecode.grid'), array('name' => 'idCountry', 'index' => 'cnt.idCountry', 'hidden' => true, 'align' => 'center', 'stype' => 'select', 'search' => true, 'title' => false));
       

        //Count search result

        $countQb = $userBusiness -> getCountUsersList($data);
        $count = count($countQb -> getQuery() -> getResult());
        $request -> getSession() -> set('users_count', $count);
        $userConfig = $this -> container -> get('user.grid');
        if ( ! ($request -> isXmlHttpRequest())) {
		
            return $this -> container -> get('templating') -> renderResponse('NearteamUserBundle:User:users_list.html.twig', $grid -> render());
        }
        else {

            return ($grid -> render());
        }
    }


    /**
     * show info user page
     * @author ABD. H.
     */
    public function getInfosUserAction($idUser, $type)
    {

        $request = $this -> container -> get('request');
        $idUser = $request -> get('idUser');
        $userBusiness = $this -> container -> get('nearteam_user.business.user');
        $countryManager = $this -> container -> get('nearteam_core.manager.country');
        $user = $userBusiness -> load($idUser);
        $country = $user -> getCountry();
        return $this -> container -> get('templating') -> renderResponse('NearteamUserBundle:User:infos_user.html.twig', array(
                    'user' => $user,
                    'country' => $country,
                    'type' => $type,
                ));
    }

    /**
     * save edit user
     * @param integer $idUser
     * @author ABD. H.
     */
    public function saveUserEditAction($idUser)
    {

        $request = $this -> container -> get('request');
        $em = $this -> container->get('doctrine.orm.entity_manager');
        $userBusiness = $this -> container -> get('nearteam_user.business.user');
        $user = $userBusiness -> load($idUser);
        $countryManager = $this -> container -> get('nearteam_core.manager.country');
        $countries = $countryManager -> loadAll();
        $request -> getSession() -> set('user_edit_gender', '');
        $gender = '';
        if ($request -> getMethod() == 'POST') {
            $valuesUser = $request -> get('nearteam_user_edit_user');
            $valuesUser[] = $request -> get('user_edit_form');
            $valuesUser[] = $request -> get('password_user_form');
            $dayBirthday = $valuesUser[0]['dateNaissance']['day'];
            $monthBirthday = $valuesUser[0]['dateNaissance']['month'];
            // ticket 6258
            $valuesUser[0]['dateNaissance']['day'] = str_pad($valuesUser[0]['dateNaissance']['day'], 2, "0", STR_PAD_LEFT);
            $valuesUser[0]['dateNaissance']['month'] = str_pad($valuesUser[0]['dateNaissance']['month'], 2, "0", STR_PAD_LEFT);
            if (isset($valuesUser['firstName'])) {
                $request -> getSession() -> set('user_edit_fisrtName', $valuesUser['firstName']);
            }
            if (isset($valuesUser['lastName'])) {
                $request -> getSession() -> set('user_edit_lastName', $valuesUser['lastName']);
            }
            if (isset($valuesUser['address'])) {
                $request -> getSession() -> set('user_edit_address', $valuesUser['address']);
            }
            if (isset($valuesUser[0]['postalCode'])) {
                $request -> getSession() -> set('user_edit_postalCode', $valuesUser[0]['postalCode']);
            }
            if (isset($valuesUser[0]['email'])) {
                $request -> getSession() -> set('user_edit_email', $valuesUser[0]['email']);
            }
            if (isset($valuesUser[0]['phone'])) {
                $request -> getSession() -> set('user_edit_phone', $valuesUser['phone']);
            }
            if (isset($valuesUser[0]['gender'])) {
                $request -> getSession() -> set('user_edit_gender', $valuesUser[0]['gender']);
            }
            if (isset($valuesUser[0]['dateNaissance']['year'])) {
                $request -> getSession() -> set('user_edit_year', $valuesUser[0]['dateNaissance']['year']);
            }
            if (isset($valuesUser[0]['dateNaissance']['day'])) {
                $request -> getSession() -> set('user_edit_day', $valuesUser[0]['dateNaissance']['day']);
            }
            if (isset($valuesUser[0]['dateNaissance']['month'])) {
                $request -> getSession() -> set('user_edit_month', $valuesUser[0]['dateNaissance']['month']);
            }
            if (isset($valuesUser[0]['city'])) {
                $request -> getSession() -> set('user_edit_city', $valuesUser[0]['city']);
            }
            if (isset($valuesUser[0]['country'])) {
                $request -> getSession() -> set('user_edit_country', $valuesUser[0]['country']);
            }

        }

        $dataEdit = $this -> listEditErrorData();
        $EditUser = new EditUser($em, $user, $countries, $dataEdit);
        $form = $this -> container -> get('form.factory') -> create(new EditUser($em, $user, $countries, $dataEdit), $user);
        $formUser = $this -> container -> get('form.factory') -> create(new UserType($em, $user, $countries));
        $formPassword = $this -> container -> get('form.factory') -> create(new PasswordType());
        if ($request -> getMethod() == 'POST') {
            $values = $form -> getData();

            $form -> bindRequest($request);
            $formPassword -> bindRequest($request);
            if ($form -> isValid() && $formPassword -> isValid()) {
                $userBusiness = $this -> get('nearteam_user.business.user');
                $logManager = $this -> get('nearteam_log.manager.log');
				$userEditFormData =  $request -> get('user_edit_form');
                if (isset($userEditFormData['gender'])) {
                    $gender = $userEditFormData['gender'];
					$user->setGender($gender);
                }
                $logManager -> updateUserLog($user, $this->getIdUser());
                $userBusiness -> userUpdate($valuesUser, $user, $gender);
                //ticket 6289
                $url = $this -> generateUrl('nearteam_user_infos', array('idUser' => $idUser, 'type' => 'save'));

                return $this -> redirect($url);
            }
            else {
               
                if ($user -> getGender() == null) {
                    $user -> setGender($request -> getSession() -> get('user_edit_gender'));
                }

                return $this -> container -> get('templating') -> renderResponse('NearteamUserBundle:User:edit_user.html.twig', array('user' => $user, 'countries' => $countries, 'form' => $form -> createView(), 'formUser' => $formUser -> createView(), 'formPassword' => $formPassword -> createView()));
            }
        }

        return $this -> container -> get('templating') -> renderResponse('NearteamUserBundle:User:edit_user.html.twig', array('user' => $user, 'countries' => $countries, 'form' => $form -> createView(), 'formUser' => $formUser -> createView(), 'formPassword' => $formPassword -> createView()));
    }

    /**
     * blacklister user
     * @author SGH. A.
     */
    public function blacklistUserAction($idUser = null)
    {

        if ($idUser != null) {
            $userBusiness = $this -> container -> get('nearteam_user.business.user');
            $user = $userBusiness -> load($idUser);

            try {
                $this -> container -> get('nearteam_log.manager.log') -> blacklistUserLog($user, $this->getIdUser());
                /*                 * ****** log user controller ******* */
                $this -> container -> get('logger') -> info('blacklistUser blacklistUserAction() user=' . $idUser);
                /*                 * ******************************** */

            } catch (\Exception $e) {
                $this -> container -> get('logger') -> err('error user blacklistUserAction() blachklist for id = ' . $idUser);
            }
        }
        $url = $this -> container -> get('router') -> generate('nearteam_user');

        return new RedirectResponse($url);
    }

    /**
     * delete user
     * @author SGH. A.
     */
    public function deleteUserAction($idUser = null)
    {
        $userBusiness = $this -> container -> get('nearteam_user.business.user');
        if ($idUser != null) {

            try {
				/*                 * ****** log user controller ******* */
				$this -> container -> get('logger') -> info('deleteUser deleteUserAction() user=' . $idUser);
				/*                 * ******************************** */
				$user = $this -> container -> get('nearteam_user.business.user') -> load($idUser);
				$this -> container -> get('nearteam_log.manager.log') -> deleteUserLog($user, $this->getIdUser());
            } catch (\Exception $e) {

                $this -> container -> get('logger') -> err('deleteUserAction() error user delete for id = ' . $idUser);
            }
        }

        $url = $this -> container -> get('router') -> generate('nearteam_user');

        return new RedirectResponse($url);
    }

    /**
     * variable recovery of sessions
     */
    public function listDataSearch()
    {
        $request = $this -> container -> get('request');
        $data = array();
        $data['mail'] = $request -> getSession() -> get('user_email', '');
        $data['firstName'] = $request -> getSession() -> get('user_firstName', '');
        $data['lastName'] = $request -> getSession() -> get('user_lastName', '');
        $data['cp'] = $request -> getSession() -> get('user_cp', '');
        $data['idUser'] = $request -> getSession() -> get('user_idUser', '');
        $data['phone'] = $request -> getSession() -> get('user_phone', '');
        $data['country'] = $request -> getSession() -> get('user_country', '');
        return $data;
    }

    /**
     * variable recovery of user
     */
    public function listEditData($user)
    {

        $data = array();
        $data['firstName'] = $user -> getFirstName();
        $data['lastName'] = $user -> getLastName();
        $data['address'] = $user -> getAddress();
        $data['email'] = $user -> getEmail();
        $data['postalCode'] = $user -> getCityZipcode() -> getPostalCode();
        $data['phone'] = $user -> getPhone();

        return $data;
    }

    /**
     * variable recovery of sessions edit
     */
    public function listEditErrorData()
    {
        $request = $this -> container -> get('request');
        $data = array();
        $data['firstName'] = $request -> getSession() -> get('user_edit_fisrtName', '');
        $data['lastName'] = $request -> getSession() -> get('user_edit_lastName', '');
        $data['address'] = $request -> getSession() -> get('user_edit_address', '');
        $data['email'] = $request -> getSession() -> get('user_edit_email', '');
        $data['postalCode'] = $request -> getSession() -> get('user_edit_postalCode', '');
        $data['phone'] = $request -> getSession() -> get('user_edit_phone', '');

        return $data;
    }

    /**
     * form search
     */
    public function searchUserAction()
    {

        $request = $this -> container -> get('request');
        $values = $request -> get('nearteam_user_search');
        $userConfig = $this -> container -> get('user.grid');
        if ($request -> getMethod() == 'POST') {
            $userConfig -> getParameters($values);
        }
        $em = $this -> container->get('doctrine.orm.entity_manager');
        $countryManager = $this -> container -> get('nearteam_core.manager.country');
        $countries = $countryManager -> loadAll();
        $dataSearch = $this -> listDataSearch();
        $searchUserType = new UserSearchType($em, $countries, $dataSearch);
        $form = $this -> container -> get('form.factory') -> create($searchUserType);
        $isValid = 0;
        if ($request -> getMethod() == 'POST') {

            $form -> bindRequest($request);
            if ($form -> isValid()) {
                $isValid = 1;
            }
        }


        $request = $this -> container -> get('request');

        return $this-> container-> get('templating') -> renderResponse('NearteamUserBundle:User:form_user_search.html.twig', array(
                    'form' => $form -> createView(),
                    'isValid' => $isValid
                ));
    }

    /**
     * change password user
     * @author BEN. Y.
     */
    public function changePasswordAction()
    {
        $request = $this -> container -> get('request');
        $userBusiness = $this -> container -> get('nearteam_user.business.user');
        $idUser = $request -> get('id_user');
        $user = $userBusiness -> load($idUser);
        try {
            $this -> container -> get('nearteam_log.manager.log') -> changeUserPasswordLog($user, $this->getIdUser());

            /*             * ****** log user controller ******* */
            $this -> container -> get('logger') -> info('changePassword changePasswordAction() user=' . $idUser);
            /*             * ******************************** */
        } catch (\Exception $e) {
            $this -> container -> get('logger') -> err('changePasswordAction() error user api changePassword for id = ' . $idUser);

            return new Response('false');
        }

        return new Response('true');
    }

   
}
