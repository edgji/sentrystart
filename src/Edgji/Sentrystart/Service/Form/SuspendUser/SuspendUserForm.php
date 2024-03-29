<?php namespace Edgji\Sentrystart\Service\Form\SuspendUser;

use Edgji\Sentrystart\Service\Validation\ValidableInterface;
use Edgji\Sentrystart\Repo\User\UserInterface;

class SuspendUserForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \Edgji\Sentrystart\Service\Validation\ValidableInterface
	 */
	protected $validator;

	/**
	 * Session Repository
     *
     * @var \Edgji\Sentrystart\Repo\Session\SessionInterface
	 */
	protected $user;

	public function __construct(ValidableInterface $validator, UserInterface $user)
	{
		$this->validator = $validator;
		$this->user = $user;
	}

	/**
     * Process the requested action
     *
     * @return integer
     */
    public function suspend(array $input)
    {

        if( ! $this->valid($input) )
        {
            return false;
        }

        return $this->user->suspend($input['id'], $input['minutes']);
    }

	/**
	 * Return any validation errors
	 *
	 * @return array 
	 */
	public function errors()
	{
		return $this->validator->errors();
	}

	/**
	 * Test if form validator passes
	 *
	 * @return boolean 
	 */
	protected function valid(array $input)
	{

		return $this->validator->with($input)->passes();
		
	}


}