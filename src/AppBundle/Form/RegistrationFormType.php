<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 11/13/2017
 * Time: 4:05 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname');
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }


}