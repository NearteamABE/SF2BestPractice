<?php

namespace Nearteam\UserBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Form\AbstractType;

class PasswordType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('password', 'password', array ('label' => 'edit.password.form', 'required' => false))
		        ->add('_token','hidden', array('data'=>'token'))
                ->add('passwordVerif', 'password', array ('label' => 'edit.passwordVerif.form', 'required' => false));
    }

    public function getName()
    {
        
        return 'password_user_form';
    }

    public function getDefaultOptions(array $options)
    {
        

        return array (
           
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention' => 'task_item',
        );
    }

}
