<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Html
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Html extends Base {

	/**
	 * @var string
	 */
	protected $_root = '';

	/**
	 * An array of consecutive html items. (required)
	 *
	 * @var array
	 */
	protected $_htmlItems = [];

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

		return implode('', array_filter($this->getHtmlItems()));

	}

	/**
	 * getHtmlItems
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  array    $_htmlItems
	 */
	public function getHtmlItems() {

		return $this->_htmlItems;

	}

	/**
	 * setHtmlItems
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   array $htmlItems
	 *
	 * @return  Html
	 */
	public function setHtmlItems($htmlItems) {

		$this->_htmlItems = $htmlItems;

		return $this;

	}

	/**
	 * addHtmlItem
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $htmlItem
	 *
	 * @return  Html
	 */
	public function addHtmlItem($htmlItem) {

		$htmlItem = trim($htmlItem);

		if (!empty($htmlItem)) {
			$this->_htmlItems[] = $htmlItem;
		}

		return $this;

	}

}
