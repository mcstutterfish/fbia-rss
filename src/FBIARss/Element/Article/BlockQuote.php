<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class BlockQuote
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class BlockQuote extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'blockquote';

	/**
	 * The text of the block quote. (required)
	 *
	 * @var string
	 */
	protected $_text = '';

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
		if (empty($this->getText())) {
			throw new \Exception('text is required for all block quotes');
		}

		return '<' . $this->getRoot() . '>' . $this->getText() . '</' . $this->getRoot() . '>';

	}

	/**
	 * getText
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_text
	 */
	public function getText() {

		return $this->_text;

	}

	/**
	 * setText
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $text
	 *
	 * @return  BlockQuote
	 */
	public function setText($text) {

		$this->_text = $text;

		return $this;

	}

}
