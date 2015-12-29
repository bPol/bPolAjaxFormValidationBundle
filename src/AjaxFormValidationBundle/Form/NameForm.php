<?php
/**
 * Date: 28.12.15
 * Time: 11:58
 */

namespace AjaxFormValidationBundle\Form;

use AjaxFormValidationBundle\Service\LocalizedConfigs;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class NameForm extends BaseValidatorForm
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
						if (!preg_match("/^[\p{L}\ ]+$/u", $value))
						{
							$context->buildViolation('this_is_not_valid_name')
								->addViolation();
						}
					}),
				],
				'invalid_message' => 'this_is_not_valid_name',
			]);
	}

	/**
	 * @return string The name of this type
	 */
	public function getName()
	{
		return 'validator';
	}

	/**
	 * @param string $locale
	 *
	 * @return $this
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;

		return $this;
	}
}