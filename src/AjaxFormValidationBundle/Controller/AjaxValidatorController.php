<?php
/**
 * Date: 28.12.15
 * Time: 11:29
 */
namespace AjaxFormValidationBundle\Controller;

use AjaxFormValidationBundle\Form\CityForm;
use AjaxFormValidationBundle\Form\EmailForm;
use AjaxFormValidationBundle\Form\GenderForm;
use AjaxFormValidationBundle\Form\NameForm;
use AjaxFormValidationBundle\Form\PasswordConfirmForm;
use AjaxFormValidationBundle\Form\PasswordForm;
use AjaxFormValidationBundle\Form\PhoneForm;
use AjaxFormValidationBundle\Form\PostCodeForm;
use AjaxFormValidationBundle\Form\StreetForm;
use AjaxFormValidationBundle\Form\UrlForm;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxValidatorController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @param $type
	 * @return RedirectResponse|Response
	 * @throws Exception
	 */
	public function indexAction(Request $request, $type)
	{
		switch ($type)
		{
			case 'gender':
				$form = $this->createForm(GenderForm::class);
				break;
			case 'name':
			case 'surname':
				$form = $this->createForm(NameForm::class);
				break;
			case 'post-code':
				$form = $this->createForm(PostCodeForm::class);
				break;
			case 'phone':
				$form = $this->createForm(PhoneForm::class);
				break;
			case 'url':
				$form = $this->createForm(UrlForm::class);
				break;
			case 'city':
				$form = $this->createForm(CityForm::class);
				break;
			case 'street':
				$form = $this->createForm(StreetForm::class);
				break;
			case 'email':
				$form = $this->createForm(EmailForm::class);
				break;
			case 'password':
				$form = $this->createForm(PasswordForm::class);
				break;
			case 'confirm':
				$form = $this->createForm(PasswordConfirmForm::class);
				break;
			default:
				throw new Exception(sprintf('Unrecognized field type `%s`', $type));
				break;
		}

		if ('confirm' == $type)
		{
			/** @var Form $form */
			$form->submit([
				'value'  => [
					'password' => $request->get('password'),
					'confirm'  => $request->get('confirm'),
				]
			]);
		}
		else
		{
			/** @var Form $form */
			$form->submit([
				'value' => $request->get('value'),
			]);
		}

		if ($form->isValid())
		{
			return new JsonResponse(null, Response::HTTP_NO_CONTENT);
		}

		return new JsonResponse([
			'errors' => array_map(function(FormError $error)
			{
				return $error->getMessage();
			}, iterator_to_array($form->getErrors(true))),
		], Response::HTTP_OK);
	}

}