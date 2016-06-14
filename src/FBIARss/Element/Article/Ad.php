<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Ad
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @since       0.1.1
 * @version     0.1.6
 */
class Ad extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'figure';

	/**
	 * The source of the ad. (required)
	 *
	 * @var string
	 */
	protected $_source = '';

	/**
	 * The height of the ad.
	 *
	 * @var string
	 */
	protected $_height = '';

	/**
	 * The width of the ad.
	 *
	 * @var string
	 */
	protected $_width = '';

	/**
	 * Ad constructor.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string|null $source
	 * @param   string|null $width
	 * @param   string|null $height
	 */
	public function __construct($source = null, $width = null, $height = null) {

		if (!is_null($source)) {

			$this->setSource($source);

			if (!empty($width)) {
				$this->setWidth($width);
			}

			if (!empty($height)) {
				$this->setHeight($height);
			}

		}

	}

	/**
	 * render
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.6
	 *
	 * @param   SimpleXMLElement|null $xmlElement
	 *
	 * @return  string
	 * @throws  \Exception
	 */
	public function render(SimpleXMLElement $xmlElement = null) {

		// check required
		if (empty($this->getSource())) {
			throw new \Exception('source is required for all ads');
		}

		// add dimensions
		$adHeight = null;
		$adWidth = null;

		if (!empty($this->getHeight())) {
			$adHeight = $this->getHeight();
		}

		if (!empty($this->getWidth())) {
			$adWidth = $this->getWidth();
		}

		$adString = '<' . $this->getRoot() . ' class="op-ad">';

		$iframeEnclosed = !$this->isValidURL($this->getSource());

		if ($iframeEnclosed) {
			$adString .= $this->getSource();
		} else {

			if (!empty($adWidth)) {
				$adString .= ' width="' . $adWidth . '"';
			}

			$adString .= ' src="' . $this->getSource() . '">';
			$adString .= '</iframe>';

		}

		if (!empty($adHeight)) {
			$adString .= ' height="' . $adHeight . '"';
		}

		$adString .= '</' . $this->getRoot() . '>';

		return $adString;

	}

	/**
	 * getSource
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string $source
	 *
	 * @return  Ad
	 */
	public function setSource($source) {

		$source = $this->stripBeginEndParagraphs($source);

		if (!empty($source)) {
			$this->_source = $source;
		}

		return $this;

	}

	/**
	 * getHeight
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @return  string    $_height
	 */
	public function getHeight() {

		return $this->_height;

	}

	/**
	 * setHeight
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string $height
	 *
	 * @return  Ad
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
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @return  string    $_width
	 */
	public function getWidth() {

		return $this->_width;

	}

	/**
	 * setWidth
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string $width
	 *
	 * @return  Ad
	 */
	public function setWidth($width) {

		$this->_width = $width;

		return $this;

	}

}
