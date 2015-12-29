<?php
/**
 * Date: 29.12.15
 * Time: 08:22
 */

namespace AjaxFormValidationBundle\Form;

use AjaxFormValidationBundle\Service\LocalizedConfigs;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class EmailForm extends BaseValidatorForm
{
	/**
	 * {@inheritDoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('value', TextType::class, [
				'constraints' => [
					new Callback(function($value, ExecutionContextInterface $context)
					{
						if (!filter_var($value, FILTER_VALIDATE_EMAIL))
						{
							$context
								->buildViolation('email_address_has_not_valid_format')
						        ->addViolation();
						}
					}),
				],
				'invalid_message' => 'email_address_has_not_valid_format',
			]);
	}

	/**
	 * @return string The name of this type
	 */
	public function getName()
	{
		return 'validator';
	}
}