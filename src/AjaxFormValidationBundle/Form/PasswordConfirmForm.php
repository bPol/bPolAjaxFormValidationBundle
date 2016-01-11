<?php
/**
 * Date: 29.12.15
 * Time: 12:39
 */

namespace AjaxFormValidationBundle\Form;

use AjaxFormValidationBundle\Service\LocalizedConfigs;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordConfirmForm extends BaseValidatorForm
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
			->add('value', RepeatedType::class, [
				'first_name'  => 'password',
				'second_name' => 'confirm',
				'constraints' => [
					new Length([
						'min' => (int) $this->config->getFormat('passwordLength'),
						'minMessage' => $this->translator->trans('password_is_too_short'),
					]),
					new NotBlank,
				],
				'invalid_message' => $this->translator->trans('passwords_are_different'),
			])
		;
	}

	/**
	 * @return string The name of this type
	 */
	public function getName()
	{
		return 'validator';
	}
}