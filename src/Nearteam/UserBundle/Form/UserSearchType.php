<?php

namespace Nearteam\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

class UserSearchType extends AbstractType
{

    /**
     * Array
     */
    private $countries;
    private $cityRepository;
    private $countryRepository;
    private $data;
    private $em;

    /**
     * @param Array $countries
     */
    public function __construct(EntityManager $em, Array $countries, $data)
    {
        $this->countryRepository = $em->getRepository('Nearteam\CoreBundle\Entity\Country');
        $this->countries = $countries;
        $this->data = $data;
        $this->em = $em;

    }

    public function buildForm(FormBuilder $builder, array $options)
    {


        $builder->add('lastName', 'text', array ('label' => 'nom.form', 'required' => false, 'attr' => array ('value' => $this->data['lastName'])))
                ->add('firstName', 'text', array ('label' => 'prenom.form', 'required' => false, 'attr' => array ('value' => $this->data['firstName'])))
                ->add('email', 'text', array ('label' => 'mail.form', 'required' => false, 'attr' => array ('value' => $this->data['mail'])))
                ->add('idUser', 'text', array ('label' => 'user_id.form', 'required' => false))
                ->add('city', 'choice', array ('required' => false,
				    'empty_value' => 'toutes.form',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'city.form',
                    'choices' => array(),
                ))
                ->add('cp', 'text', array('label' => 'cp.form', 'required' => false,'max_length' => 5))
                ->add('country', 'choice', array(
                    'required' => false,
                    'label' => 'country.form',
                    'multiple' => false,
                    'expanded' => false,
					'empty_value' => 'tous.form',
                    'choices' => $this->getCountryChoices(),
                ))
                ->add('phone', 'text', array ('label' => 'phone.form', 'required' => false, 'attr' => array ('value' => $this->data['phone'])))
				->add('_token', 'hidden', array ('data' => 'token'))
                ->addValidator(new CallbackValidator(function(FormInterface $form) {
                                    $lastName = $form->get('lastName');
                                    $firstName = $form->get('firstName');
                                    $idUser = $form->get('idUser');
                                    $cp = $form->get('cp');
                                    $phone = $form->get('phone');

                                    if (!is_null($lastName->getData())) {
                                        $validator = new RegexValidator();
                                        $constraint = new Regex(array (
                                                    'pattern' => "/^[0-9a-zA-ZÀ-ÿ' '-_)(?!]+$/"
                                                ));
                                        $isValid = $validator->isValid($lastName->getData(), $constraint);
                                        if (!$isValid) {
                                            $lastName->addError(new FormError('regx.internaute.error.msg.key'));
                                        }
                                    }

                                    if (!is_null($firstName->getData())) {
                                        $validator = new RegexValidator();
                                        $constraint = new Regex(array (
                                                    'pattern' => "/^[0-9a-zA-ZÀ-ÿ' '-_)(?!]+$/"
                                                ));
                                        $isValid = $validator->isValid($firstName->getData(), $constraint);
                                        if (!$isValid) {
                                            $firstName->addError(new FormError('regx.internaute.error.msg.key'));
                                        }
                                    }


                                    if (!is_null($idUser->getData())) {
                                        $validator = new RegexValidator();
                                        $constraint = new Regex(array (
                                                    'pattern' => "/^[0-9]+$/"
                                                ));
                                        $isValid = $validator->isValid($idUser->getData(), $constraint);
                                        if (!$isValid) {
                                            $idUser->addError(new FormError("num.error.msg.key"));
                                        }
                                    }
                                    if (!is_null($cp->getData())) {
                                        $validator = new RegexValidator();
                                        $constraint = new Regex(array (
                                                    'pattern' => "/^[0-9a-zA-ZÀ-ÿ' '-_)(?!]+$/"
                                                ));
                                        $isValid = $validator->isValid($cp->getData(), $constraint);
                                        if (!$isValid) {
                                            $cp->addError(new FormError("regx.internaute.cp.error.msg.key"));
                                        }
                                    }

                                    if (!is_null($phone->getData())) {
                                        $validator = new RegexValidator();
                                        $constraint = new Regex(array (
                                                    'pattern' => "/^[0-9]+$/"
                                                ));
                                        $isValid = $validator->isValid($phone->getData(), $constraint);
                                        if (!$isValid) {
                                            $phone->addError(new FormError("num.error.msg.key"));
                                        }
                                    }
                                }));
    }

    
    /**
     * list of countries
     *
     * @return list choices
     *
     */
    protected function getCountryChoices()
    {
        $choices = array();
        $listCountry = $this->countryRepository->findAll();
		
        foreach($listCountry as $country) {
			$choices[$country->getIdCountry()] = $country->getName();
        }

        return $choices;
    }


    public function getName()
    {

        return 'nearteam_user_search';
    }
	
	    public function getDefaultOptions(array $options)
    {

        

        return array (
            
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention' => 'task_item'
            
        );
    }

}
