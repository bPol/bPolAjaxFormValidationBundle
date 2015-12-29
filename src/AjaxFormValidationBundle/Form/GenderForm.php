<?php
/**
 * Date: 28.12.15
 * Time: 11:58
 */

namespace AjaxFormValidationBundle\Form;

use AjaxFormValidationBundle\Service\LocalizedConfigs;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class GenderForm extends BaseValidatorForm
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
			->add('value', ChoiceType::class, [
				'choices' => [
					'f' => 'female',
					'm' => 'male',
				],
				'invalid_message' => 'this_value_is_not_valid',
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