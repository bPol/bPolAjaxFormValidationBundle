<?php
/**
 * Date: 29.12.15
 * Time: 08:27
 */

namespace AjaxFormValidationBundle\Form;

use AjaxFormValidationBundle\Service\LocalizedConfigs;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UrlForm extends BaseValidatorForm
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
			->add('value', TextType::class, [
				'constraints' => [
					new Callback(function($value, ExecutionContextInterface $context)
					{
						if (!preg_match("/^" . $this->config->getFormat('url') . "$/u", $value))
						{
							$context
								->buildViolation($this->translator->trans('url_has_not_valid'))
						        ->addViolation();
						}
					}),
				],
				'invalid_message' => $this->translator->trans('url_has_not_valid'),
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