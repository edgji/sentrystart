<?php namespace Edgji\Sentrystart;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class AuthorityController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
            dd($this->layout);
			$this->layout = View::make($this->layout);
		}
	}

}
