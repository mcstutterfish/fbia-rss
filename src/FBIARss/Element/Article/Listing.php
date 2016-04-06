<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Listing
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Listing extends Base {

	/**
	 * @var string
	 */
	protected $_root = '';

	/**
	 * The individual content items that comprise this listing. (required)
	 *
	 * @var array
	 */
	protected $_items = [];

	/**
	 * Specifies whether your listing is ordered or not.
	 *
	 * @var boolean
	 */
	protected $_ordered = false;

	/**
	 * render
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param SimpleXMLElement $xmlElement
	 *
	 * @return string
	 */
	public function render(SimpleXMLElement $xmlElement = null) {

		// check required
		if (empty($this->getItems())) {
			return '';
		}

		if ($this->isOrdered()) {
			$listingString = '<ol>';
		} else {
			$listingString = '<ul>';
		}

		foreach ($this->getItems() as $item) {
			$listingString .= '<li>' . $item . '</li>';
		}

		if ($this->isOrdered()) {
			$listingString = '</ol>';
		} else {
			$listingString = '</ul>';
		}

		return $listingString;

	}

	/**
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return array
	 */
	public function getItems() {

		return $this->_items;

	}

	/**
	 * setItems
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $items
	 *
	 * @return Listing
	 */
	public function setItems($items) {

		$this->_items = $items;

		return $this;

	}

	/**
	 * isOrdered
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return boolean
	 */
	public function isOrdered() {

		return $this->_ordered;

	}

	/**
	 * setOrdered
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param boolean $ordered
	 *
	 * @return Listing
	 */
	public function setOrdered($ordered) {

		$this->_ordered = $ordered;

		return $this;

	}

}
