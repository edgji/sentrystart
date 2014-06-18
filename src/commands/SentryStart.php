<?php namespace Edgji\Sentrystart;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SentryStart extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'sentry:start';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup Sentry package migrations and create admin user.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $this->setupSentry();

        $this->setupAdmin();
	}

    /**
     * Setup sentry stuff
     *
     * @return void
     */
    private function setupSentry()
    {
        $this->line("Set up Sentry package for users, groups and permissions");

        $continue = $this->confirm('Would you like to continue? [yes|no]');

        if ($continue)
        {
            $this->call('migrate', array('--package' => 'cartalyst/sentry'));
        }
    }

    private function setupAdmin()
    {
        $app =  $this->getLaravel();
        $sentryUser = $app->make('Edgji\Sentrystart\Repo\User\UserInterface');

        $this->line("Setup a new user.");

        $email = $this->ask("What is the email address?");
        $password = $this->secret("What is the password?");

        $result = $sentryUser->store(compact('email', 'password'));

        if ($result['success'])
        {
            $activationCode = $result['mailData']['activationCode'];
            $this->info("New user with login: {$email} created!");
            $this->info("Activation code: {$activationCode}");

            $continue = $this->confirm('Do you want to activate the created user? [yes|no]');

            if ($continue)
            {
                $userId = $result['mailData']['userId'];
                $activateResult = $sentryUser->activate($userId, $activationCode);

                if ($activateResult['success'])
                {
                    $this->info("User: {$email} activated!");
                }
                else
                {
                    $this->error($activateResult['message']);
                }
            }
        }
        else
        {
            $this->error($result['message']);
        }
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
