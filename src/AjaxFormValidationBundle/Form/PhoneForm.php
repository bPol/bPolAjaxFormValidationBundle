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

class PhoneForm extends BaseValidatorForm
{

	/** @var string */
	private $locale;

	/** @var LocalizedConfigs */
	private $config;


	/**
	 * @param LocalizedConfigs $config
	 * @param $locale
	 */
	public function __construct(LocalizedConfigs $config, $locale)
	{
		$this->config = $config;
		$this->locale = $locale;
	}


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
						if (!preg_match("/^" . $this->config->getFormat('phone') . "$/u", $value))
						{
							$context
								->buildViolation('phone_number_has_not_valid_format')
						        ->addViolation();
						}
					}),
				],
				'invalid_message' => 'phone_number_has_not_valid_format',
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