<?php

namespace Nearteam\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;
use Nearteam\UserBundle\Entity\Optin;
use Nearteam\UserBundle\Entity\User;
use Nearteam\UserBundle\Repository\OptinRepository;
use Doctrine\ORM\EntityManager;

class UserType extends AbstractType
{


    /**
     * @var Nearteam\UserBundle\Entity\User
     */
    protected $user;

    /**
     * Array
     */
    protected $countries;

    /**
     * @var Nearteam\CoreBundle\CountryRepository
     */
    protected $countryRepository;

    
	
    protected $em;


    /**
     *
     * @param EntityManager $em
     * @param User $user
     * @param Array $countries
     */
    public function __construct(EntityManager $em, User $user, Array $countries)
    {
        $this->em = $em;
        $this->countryRepository = $em->getRepository('Nearteam\CoreBundle\Entity\Country');
        $this->user = $user;
        $this->countries = $countries;
    }

    public function getDefaultOptions(array $options)
    {

        $collectionConstraint = new Collection(array (
                    'password' => array (new MinLength(array ('limit' => 1, 'message' => 'Sujet trop court'))),
                ));

        return array (
            'data_class' => 'Nearteam\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention' => 'task_item',
            'validation_constraint' => $collectionConstraint,
			 'csrf_field_name' => '_token',
        );
    }

    public function buildForm(FormBuilder $builder, array $options) 
    {
        
        $builder->add('gender', 'choice', array ('multiple' => false,
                    'expanded' => true,
                    'choices' => array ('M' => 'Homme.key', 'F' => 'Femme.key')))
                ->add('dateNaissance', 'birthday',  array ('required' => false, 'empty_value' =>'aucun.key','attr'=>array('class'=>'span12')))
                ->add('country', 'choice', array ('required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'city.form',
                    'choices' => $this->getCountryChoices(), 'attr' => array ('class' => 'selecth')
                ))
				->add('postalCode', 'text', array('label' => 'edit.postalCode.form', 'required' => false,'max_length' => 5, 'attr' => array('onChange'=>'listVille(0)')))
               
                ->add('year', 'choice', array ('required' => false))
                ->add('day', 'choice', array ('required' => false))
				->add('_token','hidden', array('data'=>'token'));
          
    }

    public function getName()
    {
        
        return 'user_edit_form';
    }

   
    protected function getCountryChoices()
    {
       
        $listCountries = $this->countryRepository->findAll();
        foreach ($listCountries as $country) {

            $choices[$country->getIdCountry()] = $country->getName();
        }

        return $choices;
    }


   

    

}