<?php

namespace VizuaaLOG\Recaptcha;

use App;
use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
	/**
	* Perform post-registration booting of services.
	*
	* @return void
	*/
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/config/recaptcha.php' => config_path('recaptcha.php'),
		]);
	}

	/**
	 * Register the Modules module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__ . '/config/recaptcha.php', 'recaptcha'
		);

		$this->app->bind('recaptcha', \VizuaaLOG\Recaptcha\Recaptcha::class);
	}
}
