<?php

namespace Nearteam\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Nearteam\UserBundle\Entity\User;
use Nearteam\CoreBundle\Entity\Country;
use Nearteam\CoreBundle\Repository\CountryRepository;
use Doctrine\ORM\EntityManager;

class EditUser extends AbstractType
{

    /**
     * @var Nearteam\UserBundle\Entity\User
     */
    protected $user;

    /**
     * Array
     */
    protected $countries;
    protected $data;

    /**
     *
     * @param EntityManager $em
     * @param User $user
     * @param Array $countries
     */
    public function __construct(EntityManager $em, User $user, Array $countries, $data)
    {
        $this->user = $user;
        $this->countries = $countries;
        $this->data = $data;
    }

    public function getDefaultOptions(array $options)
    {
        return array (
            'data_class' => 'Nearteam\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention' => 'task_item');
    }

    public function buildForm(FormBuilder $builder, array $options)
    {


        if (!empty($this->data['firstName'])) {
            $firstName = $this->data['firstName'];
        } else {
            $firstName = $this->user->getFirstName();
        }
        if (!empty($this->data['lastName'])) {
            $lastName = $this->data['lastName'];
        } else {
            $lastName = $this->user->getLastName();
        }


        if (!empty($this->data['address'])) {
            $address = $this->data['address'];
        } else {
            $address = $this->user->getAddress();
        }

        if (!empty($this->data['postalCode'])) {
            $PostalCode = $this->data['postalCode'];
        } 


        if (!empty($this->data['email'])) {
            $email = $this->data['email'];
        } else {
            $email = $this->user->getEmail();
        }

    
        $phone = $this->user->getPhone();
	   
         
        $builder->add('firstName', 'text', array('label' => 'edit.firstName.form', 'required' => false))
                ->add('lastName', 'text', array('label' => 'edit.lastName.form', 'required' => false))
                ->add('address', 'text', array('label' => 'edit.address.form', 'required' => false))
                ->add('email', 'text', array('label' => 'edit.email.form', 'required' => false))
                ->add('phone', 'text', array('label' => 'edit.phone.form', 'required' => false, 'attr' => array ('value' => $phone))) 
				->add('gender', 'choice', array( 'choices' => array('M' => 'Homme.key', 'F' => 'Femme.key')))
				->add('_token','hidden', array('data'=>'token')); 
    }

    public function getName()
    {
	
        return 'nearteam_user_edit_user';
    }

    
}
