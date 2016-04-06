<?php namespace FBIARss;

use Illuminate\Support\ServiceProvider;

/**
 * Class FBIARssServiceProvider
 *
 * @package     FBIARss
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class FBIARssServiceProvider extends ServiceProvider {

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
	public function boot() {

		$this->package('mcstutterfish/FBIARss', 'fbiarss');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

		$this->app['fbiarss'] = $this->app->share(
			function ($app) {
				return new FBIARss;
			}
		);

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {

		return ['fbiarss'];

	}

}
