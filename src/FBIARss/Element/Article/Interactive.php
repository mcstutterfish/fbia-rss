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
 * @since       0.1.1
 * @version     0.1.4
 *
 * @author      Christopher M. Black <cblack@devonium.com>
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
	protected $_caption = null;

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
	 * @since   0.1.1
	 * @version 0.1.1
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
			foreach ($this->getCaption() as $caption) {
				$interactiveString .= $caption->render();
			}
		}

		$interactiveString .= '</' . $this->getRoot() . '>';

		return $interactiveString;

	}

	/**
	 * getSource
	 *
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.4
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
	 * @since   0.1.1
	 * @version 0.1.4
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
	 * @since   0.1.1
	 * @version 0.1.4
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array $options        valid options:
	 *                              - title
	 *                              - titleFontSize
	 *                              - titlePositioning
	 *                              - titleHorizontalAlignment
	 *                              - titleVerticalAlignment
	 *                              - credit
	 *                              - creditFontSize
	 *                              - creditPositioning
	 *                              - creditHorizontalAlignment
	 *                              - creditVerticalAlignment
	 *                              - body
	 *                              - fontSize (body font size if individual elements are aligned)
	 *                              - positioning (body positioning if individual elements are aligned)
	 *                              - horizontalAlignment (body horizontal alignment  if individual elements are aligned)
	 *                              - verticalAlignment (body vertical alignment if individual elements are aligned)
	 *
	 * @return Interactive
	 */
	public function createCaption($options = []) {

		return $this->setCaption(new Caption($options));

	}

}
