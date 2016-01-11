<?php
/**
 * Date: 28.12.15
 * Time: 11:58
 */

namespace AjaxFormValidationBundle\Form;

use AjaxFormValidationBundle\Service\LocalizedConfigs;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class GenderForm extends BaseValidatorForm
{

	/** @var string */
	private $locale;

	/** @var LocalizedConfigs */
	private $config;

	/** @var TranslatorInterface */
	private $translator;


	/**
	 * @param LocalizedConfigs $config
	 * @param $locale
	 * @param TranslatorInterface $translator
	 */
	public function __construct(LocalizedConfigs $config, $locale, TranslatorInterface $translator)
	{
		$this->config = $config;
		$this->locale = $locale;
		$this->translator = $translator;
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
				'invalid_message' => $this->translator->trans('this_value_is_not_valid'),
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