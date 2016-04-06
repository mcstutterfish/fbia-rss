<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class BodyText
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class BodyText extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'p';

	/**
	 * The text of the body text. (required)
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
			throw new \Exception('text is required for all body texts');
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
	 * @return  BodyText
	 */
	public function setText($text) {

		$this->_text = $this->stripBeginEndParagraphs($text);

		return $this;

	}

}
