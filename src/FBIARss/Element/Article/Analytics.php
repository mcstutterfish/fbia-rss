<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Analytics
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Analytics extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'figure';

	/**
	 * The source of the analytics. (required)
	 *
	 * @var string
	 */
	protected $_source = '';

	/**
	 * render
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param SimpleXMLElement $xmlElement
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function render(SimpleXMLElement $xmlElement = null) {

		// check required
		if (empty($this->getSource())) {
			throw new \Exception('source is required for all analytics');
		}

		$analyticsString = '<' . $this->getRoot() . ' class="op-tracker">  <iframe';

		if ($this->isValidURL($this->getSource())) {
			$analyticsString .= ' src="' . $this->getSource() . '">';
		} else {
			$analyticsString .= '>' . $this->getSource();
		}
		$analyticsString .= '</iframe>';

		$analyticsString .= '</' . $this->getRoot() . '>';

		return $analyticsString;

	}

	/**
	 * getSource
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_source
	 */
	public function getSource() {

		return $this->_source;

	}

	/**
	 * setSource
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $source
	 *
	 * @return  Analytics
	 */
	public function setSource($source) {

		$this->_source = $source;

		return $this;

	}

}
