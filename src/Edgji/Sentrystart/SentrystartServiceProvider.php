<?php namespace Edgji\Sentrystart;

use Illuminate\Support\ServiceProvider;

use Edgji\Sentrystart\Repo\Session\SentrySession;
use Edgji\Sentrystart\Repo\User\SentryUser;
use Edgji\Sentrystart\Repo\Group\SentryGroup;
use Edgji\Sentrystart\Service\Form\Login\LoginForm;
use Edgji\Sentrystart\Service\Form\Login\LoginFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\Register\RegisterForm;
use Edgji\Sentrystart\Service\Form\Register\RegisterFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\Group\GroupForm;
use Edgji\Sentrystart\Service\Form\Group\GroupFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\User\UserForm;
use Edgji\Sentrystart\Service\Form\User\UserFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\ResendActivation\ResendActivationForm;
use Edgji\Sentrystart\Service\Form\ResendActivation\ResendActivationFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\ForgotPassword\ForgotPasswordForm;
use Edgji\Sentrystart\Service\Form\ForgotPassword\ForgotPasswordFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\ChangePassword\ChangePasswordForm;
use Edgji\Sentrystart\Service\Form\ChangePassword\ChangePasswordFormLaravelValidator;
use Edgji\Sentrystart\Service\Form\SuspendUser\SuspendUserForm;
use Edgji\Sentrystart\Service\Form\SuspendUser\SuspendUserFormLaravelValidator;

class SentrystartServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        $this->package('edgji/sentrystart');

        $this->app['sentry.start'] = $this->app->share(function($app)
        {
           return new SentryStart();
        });

        $this->commands('sentry.start');

        // Retrieve the config
        $config = $app['config']['sentrystart'] ?: $app['config']['sentrystart::config'];

        // default routing for auth
        if ($config['include_routes'])
        {
            include __DIR__.'/../../routes.php';
        }

        // load observable events and handlers.
        if ($config['include_observables'])
        {
            include __DIR__.'/../../observables.php';
        }
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $app = $this->app;

        /**
         * Repos
         */

        // Bind the Session Repository
        $app->bind('Edgji\Sentrystart\Repo\Session\SessionInterface', function($app)
        {
            return new SentrySession(
                $app['sentry']
            );
        });

        // Bind the User Repository
        $app->bind('Edgji\Sentrystart\Repo\User\UserInterface', function($app)
        {
            return new SentryUser(
                $app['sentry']
            );
        });

        // Bind the Group Repository
        $app->bind('Edgji\Sentrystart\Repo\Group\GroupInterface', function($app)
        {
            return new SentryGroup(
                $app['sentry']
            );
        });

        /**
         * Forms
         */

        // Bind the Login Form
        $app->bind('Edgji\Sentrystart\Service\Form\Login\LoginForm', function($app)
        {
            return new LoginForm(
                new LoginFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\Session\SessionInterface')
            );
        });

        // Bind the Register Form
        $app->bind('Edgji\Sentrystart\Service\Form\Register\RegisterForm', function($app)
        {
            return new RegisterForm(
                new RegisterFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\User\UserInterface')
            );
        });

        // Bind the Group Form
        $app->bind('Edgji\Sentrystart\Service\Form\Group\GroupForm', function($app)
        {
            return new GroupForm(
                new GroupFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\Group\GroupInterface')
            );
        });

        // Bind the User Form
        $app->bind('Edgji\Sentrystart\Service\Form\User\UserForm', function($app)
        {
            return new UserForm(
                new UserFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\User\UserInterface')
            );
        });

        // Bind the Resend Activation Form
        $app->bind('Edgji\Sentrystart\Service\Form\ResendActivation\ResendActivationForm', function($app)
        {
            return new ResendActivationForm(
                new ResendActivationFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\User\UserInterface')
            );
        });

        // Bind the Forgot Password Form
        $app->bind('Edgji\Sentrystart\Service\Form\ForgotPassword\ForgotPasswordForm', function($app)
        {
            return new ForgotPasswordForm(
                new ForgotPasswordFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\User\UserInterface')
            );
        });

        // Bind the Change Password Form
        $app->bind('Edgji\Sentrystart\Service\Form\ChangePassword\ChangePasswordForm', function($app)
        {
            return new ChangePasswordForm(
                new ChangePasswordFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\User\UserInterface')
            );
        });

        // Bind the Suspend User Form
        $app->bind('Edgji\Sentrystart\Service\Form\SuspendUser\SuspendUserForm', function($app)
        {
            return new SuspendUserForm(
                new SuspendUserFormLaravelValidator( $app['validator'] ),
                $app->make('Edgji\Sentrystart\Repo\User\UserInterface')
            );
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
