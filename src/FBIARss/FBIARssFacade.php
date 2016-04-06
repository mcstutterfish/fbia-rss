<?php namespace FBIARss;

use Illuminate\Support\Facades\Facade;

/**
 * Class FBIARssFacade
 *
 * @package     FBIARss
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class FBIARssFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'fbiarss'; }

}
