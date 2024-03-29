<?php namespace Edgji\Sentrystart\Service\Form\SuspendUser;

use Edgji\Sentrystart\Service\Validation\AbstractLaravelValidator;

class SuspendUserFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'minutes' => 'required|numeric',
	);

	/**
	 * Custom Validation Messages
	 *
	 * @var Array 
	 */
	protected $messages = array(
		'minutes.numeric' => 'Minutes must be a number',
		'minutes.required' => 'You must specify suspension length in minutes'
	);
}