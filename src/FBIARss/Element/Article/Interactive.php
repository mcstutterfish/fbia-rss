<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Interactive
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Interactive extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'figure';

	/**
	 * The source of the markup for your interactive graphic. (required)
	 *
	 * @var string
	 */
	protected $_source = '';

	/**
	 * Descriptive text for your interactive graphic.
	 *
	 * @var \FBIARss\Element\Article\Caption
	 */
	protected $_caption = '';

	/**
	 * The height of your interactive graphic.
	 *
	 * @var string
	 */
	protected $_height = null;

	/**
	 * The width of your interactive graphic.
	 *
	 * @var string
	 */
	protected $_width = 'no-margin';

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
			throw new \Exception('Source is required for all Interactives');
		}

		$interactiveString = '<' . $this->getRoot() . ' class="op-interactive">';

		$iframeEnclosed = !$this->isValidURL($this->getSource());
		$height         = $this->getHeight(true);
		$height         = empty($height)
			? ''
			: ' ' . $height;

		if ($iframeEnclosed) {
			$interactiveString .= '<iframe ' . $this->getWidth(true) . $height . '>' . $this->getSource() . '</iframe>';
		} else {
			$interactiveString .= '<iframe src="' . $this->getSource() . '" ' . $this->getWidth(true) . $height . '></iframe>';
		}

		if (!empty($this->getCaption())) {
			$interactiveString .= $this->getCaption()
				->render();
		}

		$interactiveString .= '</' . $this->getRoot() . '>';

		return $interactiveString;

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
	 * @return Interactive
	 * @throws \Exception
	 */
	public function setSource($source) {

		$this->_source = $source;

		return $this;

	}

	/**
	 * getHeight
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param boolean $wrapElement
	 *
	 * @return string
	 */
	public function getHeight($wrapElement = false) {

		if ($wrapElement && !empty($this->_height)) {
			return 'height="' . $this->_height . '"';
		}

		return $this->_height;

	}

	/**
	 * setHeight
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $height
	 *
	 * @return Interactive
	 */
	public function setHeight($height) {

		$this->_height = $height;

		return $this;

	}

	/**
	 * getWidth
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param boolean $wrapElement
	 *
	 * @return string
	 */
	public function getWidth($wrapElement = false) {

		if ($wrapElement && !empty($this->_width)) {
			return 'width="' . $this->_width . '"';
		}

		return $this->_width;

	}

	/**
	 * setWidth
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $width
	 *
	 * @return Interactive
	 */
	public function setWidth($width) {

		if (in_array($width, ['no-margin', 'column-width'])) {
			$this->_width = $width;
		} else {
			$this->_width = 'no-margin';
		}

		return $this;

	}

	/**
	 * getCaption
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Caption    $_caption
	 */
	public function getCaption() {

		return $this->_caption;

	}

	/**
	 * setCaption
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   Caption $caption
	 *
	 * @return  Interactive
	 */
	public function setCaption(Caption $caption) {

		$this->_caption = $caption;

		return $this;

	}

	/**
	 * createCaption
	 *
	 * Setup Caption object
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $title
	 * @param string $credit
	 * @param string $body
	 * @param string $positioning
	 * @param string $horizontalAlignment
	 * @param string $verticalAlignment
	 *
	 * @return Interactive
	 */
	public function createCaption($title,
		$credit = null,
		$body = null,
		$positioning = null,
		$horizontalAlignment = null,
		$verticalAlignment = null) {

		return $this->setCaption(new Caption($title, $credit, $body, $positioning, $horizontalAlignment, $verticalAlignment));

	}

}
