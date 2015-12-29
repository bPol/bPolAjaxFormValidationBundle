<?php
/**
 * Date: 28.12.15
 * Time: 13:31
 */


namespace AjaxFormValidationBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseValidatorForm extends AbstractType
{

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'csrf_protection' => false,
            ]);
    }

}