<?php namespace Edgji\Sentrystart\Service\Form\Login;

use Edgji\Sentrystart\Service\Validation\ValidableInterface;
use Edgji\Sentrystart\Repo\Session\SessionInterface;

class LoginForm {

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
	protected $session;

	public function __construct(ValidableInterface $validator, SessionInterface $session)
	{
		$this->validator = $validator;
		$this->session = $session;

	}

	/**
     * Create a new session
     *
     * @return integer
     */
    public function save(array $input)
    {
        if( ! $this->valid($input) )
        {
            return false;
        }

        return $this->session->store($input);
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