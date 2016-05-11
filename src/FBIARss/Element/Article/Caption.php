<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Caption
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @since       0.1.1
 * @version     0.1.4
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 */
class Caption extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'figcaption';

	/**
	 * A title for the captioned content. (required)
	 *
	 * @var string
	 */
	protected $_title = '';

	/**
	 * A body for the captioned content. Comes after the title and before the credit
	 *
	 * @var string
	 */
	protected $_body = '';

	/**
	 * An attribution to the originator/creator of the content.
	 *
	 * @var string
	 */
	protected $_credit = '';

	/**
	 * The size of the font used in the text of the caption.
	 *
	 * @var string
	 */
	protected $_fontSize = '';

	/**
	 * The size of the font title text within its container.
	 *
	 * @var string
	 */
	protected $_titleFontSize = '';

	/**
	 * The size of the font credit text within its container.
	 *
	 * @var string
	 */
	protected $_creditFontSize = '';

	/**
	 * The horizontal alignment of the caption text within its container.
	 *
	 * @var string
	 */
	protected $_horizontalAlignment = '';

	/**
	 * The horizontal alignment of the caption title text within its container.
	 *
	 * @var string
	 */
	protected $_titleHorizontalAlignment = '';

	/**
	 * The horizontal alignment of the caption credit text within its container.
	 *
	 * @var string
	 */
	protected $_creditHorizontalAlignment = '';

	/**
	 * The positioning style of the caption for a rich media element.
	 *
	 * @var string
	 */
	protected $_positioning = '';

	/**
	 * The positioning style of the caption title for a rich media element.
	 *
	 * @var string
	 */
	protected $_titlePositioning = '';

	/**
	 * The positioning style of the caption credit for a rich media element.
	 *
	 * @var string
	 */
	protected $_creditPositioning = '';

	/**
	 * The vertical alignment of the caption text within its container.
	 *
	 * @var string
	 */
	protected $_verticalAlignment = '';

	/**
	 * The vertical alignment of the caption title text within its container.
	 *
	 * @var string
	 */
	protected $_titleVerticalAlignment = '';

	/**
	 * The vertical alignment of the caption credit text within its container.
	 *
	 * @var string
	 */
	protected $_creditVerticalAlignment = '';

	/**
	 * Caption constructor.
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
	 */
	public function __construct($options = []) {

		if (!empty($options) && !empty($options['title'])) {

			$this->setTitle($options['title']);

			if (!empty($options['titlePositioning'])) {
				$this->setTitlePositioning($options['titlePositioning']);
			}

			if (!empty($options['titleHorizontalAlignment'])) {
				$this->setTitleHorizontalAlignment($options['titleHorizontalAlignment']);
			}

			if (!empty($options['titleVerticalAlignment'])) {
				$this->setTitleVerticalAlignment($options['titleVerticalAlignment']);
			}

			// Check for and set credit vars
			if (!empty($options['credit'])) {
				$this->setCredit($options['credit']);
			}

			if (!empty($options['creditPositioning'])) {
				$this->setCreditPositioning($options['creditPositioning']);
			}

			if (!empty($options['creditHorizontalAlignment'])) {
				$this->setCreditHorizontalAlignment($options['creditHorizontalAlignment']);
			}

			if (!empty($options['creditVerticalAlignment'])) {
				$this->setCreditVerticalAlignment($options['creditVerticalAlignment']);
			}

			if (!empty($options['body'])) {
				$this->setBody($options['body']);
			}

			if (!empty($options['fontSize'])) {
				$this->setFontSize($options['fontSize']);
			}

			if (!empty($options['positioning'])) {
				$this->setPositioning($options['positioning']);
			}

			if (!empty($options['horizontalAlignment'])) {
				$this->setHorizontalAlignment($options['horizontalAlignment']);
			}

			if (!empty($options['verticalAlignment'])) {
				$this->setVerticalAlignment($options['verticalAlignment']);
			}

		}

	}

	/**
	 * render
	 *
	 * @since   0.1.1
	 * @version 0.1.4
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   SimpleXMLElement $xmlElement
	 *
	 * @return  string
	 * @throws  \Exception
	 */
	public function render(SimpleXMLElement $xmlElement = null) {

		// check required
		if (empty($this->getTitle())) {
			throw new \Exception('Title is required for all captions');
		}

		// setup overall positioning / font size
		$classString = '';

		if (!empty($this->getPositioning()) || !empty($this->getFontSize())) {

			$classString = $this->getPositioning();

			if (!empty($this->getFontSize())) {

				$classString = empty($classString)
					? $this->getFontSize()
					: $classString . ' ' . $this->getFontSize();

			}

			$classString = (!empty($classString)
				? ' class="' . $classString . '"'
				: '');

		}

		$captionString = '<' . $this->getRoot() . $classString . '>';

		// setup title
		$classString = '';

		if (!empty($this->getTitlePositioning()) || !empty($this->getTitleFontSize()) || !empty($this->getTitleHorizontalAlignment()) || !empty($this->getTitleVerticalAlignment())) {

			$classString = $this->getTitlePositioning();

			if (!empty($this->getTitleFontSize())) {

				$classString = empty($classString)
					? $this->getTitleFontSize()
					: $classString . ' ' . $this->getTitleFontSize();

			}

			if (!empty($this->getTitleHorizontalAlignment())) {

				$classString = empty($classString)
					? $this->getTitleHorizontalAlignment()
					: $classString . ' ' . $this->getTitleHorizontalAlignment();

			}

			if (!empty($this->getTitleVerticalAlignment())) {

				$classString = empty($classString)
					? $this->getTitleVerticalAlignment()
					: $classString . ' ' . $this->getTitleVerticalAlignment();

			}

			$classString = (!empty($classString)
				? ' class="' . $classString . '"'
				: '');

		}

		$captionString .= '<h1' . $classString . '>' . $this->getTitle() . '</h1>';

		// add body (if set)
		if (empty($this->getBody())) {
			$captionString .= $this->getBody();
		}

		// setup credit
		if (!empty($this->getCreditPositioning()) || !empty($this->getCreditFontSize()) || !empty($this->getCreditHorizontalAlignment()) || !empty($this->getCreditVerticalAlignment())) {

			$classString = $this->getCreditPositioning();

			if (!empty($this->getCreditFontSize())) {

				$classString = empty($classString)
					? $this->getCreditFontSize()
					: $classString . ' ' . $this->getCreditFontSize();

			}

			if (!empty($this->getCreditHorizontalAlignment())) {

				$classString = empty($classString)
					? $this->getCreditHorizontalAlignment()
					: $classString . ' ' . $this->getCreditHorizontalAlignment();

			}

			if (!empty($this->getCreditVerticalAlignment())) {

				$classString = empty($classString)
					? $this->getCreditVerticalAlignment()
					: $classString . ' ' . $this->getCreditVerticalAlignment();

			}

			$classString = (!empty($classString)
				? ' class="' . $classString . '"'
				: '');

			$captionString .= '<cite' . $classString . '>' . $this->getCredit() . '</cite>';

		}

		$captionString .= '</' . $this->getRoot() . '>';

		return $captionString;

	}

	/**
	 * getTitle
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_title
	 */
	public function getTitle() {

		return $this->_title;

	}

	/**
	 * setTitle
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $title
	 *
	 * @return  Caption
	 */
	public function setTitle($title) {

		$this->_title = $title;

		return $this;

	}

	/**
	 * getPositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_positioning
	 */
	public function getPositioning() {

		return $this->_positioning;

	}

	/**
	 * setPositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $positioning
	 *
	 * @return Caption
	 * @throws \Exception
	 */
	public function setPositioning($positioning) {

		$this->_positioning = $this->_validPositioning($positioning);

		return $this;

	}

	/**
	 * getFontSize
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_fontSize
	 */
	public function getFontSize() {

		return $this->_fontSize;

	}

	/**
	 * setFontSize
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $fontSize
	 *
	 * @return Caption
	 * @throws \Exception
	 */
	public function setFontSize($fontSize) {

		$this->_fontSize = $this->_validFontSize($fontSize);

		return $this;

	}

	/**
	 * getTitlePositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_titlePositioning
	 */
	public function getTitlePositioning() {

		return $this->_titlePositioning;

	}

	/**
	 * setTitlePositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $titlePositioning
	 *
	 * @return  Caption
	 */
	public function setTitlePositioning($titlePositioning) {

		$this->_titlePositioning = $this->_validPositioning($titlePositioning);

		return $this;

	}

	/**
	 * getTitleFontSize
	 *
	 * @since   0.1.4
	 * @version 0.1.4
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_titleFontSize
	 */
	public function getTitleFontSize() {

		return $this->_titleFontSize;

	}

	/**
	 * setTitleFontSize
	 *
	 * @since   0.1.4
	 * @version 0.1.4
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $titleFontSize
	 *
	 * @return  Caption
	 */
	public function setTitleFontSize($titleFontSize) {

		$this->_titleFontSize = $titleFontSize;

		return $this;

	}

	/**
	 * getTitleHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_titleHorizontalAlignment
	 */
	public function getTitleHorizontalAlignment() {

		return $this->_titleHorizontalAlignment;

	}

	/**
	 * setTitleHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $titleHorizontalAlignment
	 *
	 * @return  Caption
	 */
	public function setTitleHorizontalAlignment($titleHorizontalAlignment) {

		$this->_titleHorizontalAlignment = $this->_validHorizontalAlignment($titleHorizontalAlignment);

		return $this;

	}

	/**
	 * getTitleVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_titleVerticalAlignment
	 */
	public function getTitleVerticalAlignment() {

		return $this->_titleVerticalAlignment;

	}

	/**
	 * setTitleVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $titleVerticalAlignment
	 *
	 * @return  Caption
	 */
	public function setTitleVerticalAlignment($titleVerticalAlignment) {

		$this->_titleVerticalAlignment = $this->_validVerticalAlignment($titleVerticalAlignment);

		return $this;

	}

	/**
	 * getBody
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_body
	 */
	public function getBody() {

		return $this->_body;

	}

	/**
	 * setBody
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $body
	 *
	 * @return  Caption
	 */
	public function setBody($body) {

		$this->_body = $body;

		return $this;

	}

	/**
	 * getCreditPositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_creditPositioning
	 */
	public function getCreditPositioning() {

		return $this->_creditPositioning;

	}

	/**
	 * setCreditPositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $creditPositioning
	 *
	 * @return  Caption
	 */
	public function setCreditPositioning($creditPositioning) {

		$this->_creditPositioning = $this->_validPositioning($creditPositioning);

		return $this;

	}

	/**
	 * getCreditFontSize
	 *
	 * @since   0.1.4
	 * @version 0.1.4
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_creditFontSize
	 */
	public function getCreditFontSize() {

		return $this->_creditFontSize;

	}

	/**
	 * setCreditFontSize
	 *
	 * @since   0.1.4
	 * @version 0.1.4
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $creditFontSize
	 *
	 * @return  Caption
	 */
	public function setCreditFontSize($creditFontSize) {

		$this->_creditFontSize = $creditFontSize;

		return $this;

	}

	/**
	 * getCreditHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_creditHorizontalAlignment
	 */
	public function getCreditHorizontalAlignment() {

		return $this->_creditHorizontalAlignment;

	}

	/**
	 * setCreditHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $creditHorizontalAlignment
	 *
	 * @return  Caption
	 */
	public function setCreditHorizontalAlignment($creditHorizontalAlignment) {

		$this->_creditHorizontalAlignment = $this->_validHorizontalAlignment($creditHorizontalAlignment);

		return $this;

	}

	/**
	 * getCreditVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_creditVerticalAlignment
	 */
	public function getCreditVerticalAlignment() {

		return $this->_creditVerticalAlignment;

	}

	/**
	 * setCreditVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $creditVerticalAlignment
	 *
	 * @return  Caption
	 */
	public function setCreditVerticalAlignment($creditVerticalAlignment) {

		$this->_creditVerticalAlignment = $this->_validVerticalAlignment($creditVerticalAlignment);

		return $this;

	}

	/**
	 * getCredit
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_credit
	 */
	public function getCredit() {

		return $this->_credit;

	}

	/**
	 * setCredit
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $credit
	 *
	 * @return  Caption
	 */
	public function setCredit($credit) {

		$this->_credit = $credit;

		return $this;

	}

	/**
	 * getHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_horizontalAlignment
	 */
	public function getHorizontalAlignment() {

		return $this->_horizontalAlignment;

	}

	/**
	 * setHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $horizontalAlignment
	 *
	 * @return Caption
	 * @throws \Exception
	 */
	public function setHorizontalAlignment($horizontalAlignment) {

		$this->_horizontalAlignment = $this->_validHorizontalAlignment($horizontalAlignment);

		return $this;

	}

	/**
	 * getVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_verticalAlignment
	 */
	public function getVerticalAlignment() {

		return $this->_verticalAlignment;

	}

	/**
	 * setVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $verticalAlignment
	 *
	 * @return Caption
	 * @throws \Exception
	 */
	public function setVerticalAlignment($verticalAlignment) {

		$this->_verticalAlignment = $this->_validVerticalAlignment($verticalAlignment);

		return $this;

	}

	/**
	 * _validFontSize
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $fontSize
	 *
	 * @return string
	 */
	protected function _validFontSize($fontSize) {

		$validOptions = [
			'medium' => 'op-medium',
			'large' => 'op-large',
			'extra-large' => 'op-extra-large',
			'extralarge' => 'op-extra-large',
			'm' => 'op-medium',
			'l' => 'op-large',
			'xl' => 'op-extra-large',
		];

		$fontSize = strtolower(trim($fontSize));

		if (in_array($fontSize, $validOptions)) {
			return $fontSize;
		} elseif (array_key_exists($fontSize, $validOptions)) {
			return $validOptions[$fontSize];
		}

		return '';

	}

	/**
	 * _validPositioning
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $positioning
	 *
	 * @return string
	 */
	protected function _validPositioning($positioning) {

		$validOptions = [
			'below' => 'op-vertical-below',
			'above' => 'op-vertical-above',
			'center' => 'op-vertical-center',
			'vertical-below' => 'op-vertical-below',
			'vertical-above' => 'op-vertical-above',
			'vertical-center' => 'op-vertical-center',
		];

		$positioning = strtolower(trim($positioning));

		if (in_array($positioning, $validOptions)) {
			return $positioning;
		} elseif (array_key_exists($positioning, $validOptions)) {
			return $validOptions[$positioning];
		}

		return '';

	}

	/**
	 * _validHorizontalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $horizontalAlignment
	 *
	 * @return string
	 */
	protected function _validHorizontalAlignment($horizontalAlignment) {

		$validOptions = [
			'left' => 'op-left',
			'center' => 'op-center',
			'right' => 'op-right',
		];

		$horizontalAlignment = strtolower(trim($horizontalAlignment));

		if (in_array($horizontalAlignment, $validOptions)) {
			return $horizontalAlignment;
		} elseif (array_key_exists($horizontalAlignment, $validOptions)) {
			return $validOptions[$horizontalAlignment];
		}

		return '';

	}

	/**
	 * _validVerticalAlignment
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $verticalAlignment
	 *
	 * @return string
	 */
	protected function _validVerticalAlignment($verticalAlignment) {

		$validOptions = [
			'bottom' => 'op-vertical-bottom',
			'center' => 'op-vertical-center',
			'top' => 'op-vertical-top',
			'vertical-bottom' => 'op-vertical-bottom',
			'vertical-center' => 'op-vertical-center',
			'vertical-top' => 'op-vertical-top',
		];

		$verticalAlignment = strtolower(trim($verticalAlignment));

		if (in_array($verticalAlignment, $validOptions)) {
			return $verticalAlignment;
		} elseif (array_key_exists($verticalAlignment, $validOptions)) {
			return $validOptions[$verticalAlignment];
		}

		return '';

	}

}
