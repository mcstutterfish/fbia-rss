<?php
namespace FBIARss\Element;

use FBIARss\SimpleXMLElement;

/**
 * Class Head
 *
 * @package     FBIARss\Element
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Head extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'head';

	/**
	 * @var string
	 */
	protected $_articleStyle = '';

	/**
	 * @var bool
	 */
	protected $_useAutomaticAdPlacement = false;

	/**
	 * @var string
	 */
	protected $_charset = 'UTF-8';

	/**
	 * @var string
	 */
	protected $_markupVersion = 'v1.0';

	/**
	 * @var string
	 */
	protected $_canonicalLink = '=';

	/**
	 * @var array
	 */
	protected $_tags = [];

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

		$headString = '        <' . $this->getRoot() . '>';

		// Add charset
		if (!empty($this->getCharset())) {
			$headString .= '          <meta charset="' . $this->getCharset() . '">';
		}

		// add canonical link
		if (!empty($this->getCanonicalLink())) {
			$headString .= '          <link rel="canonical" href="' . $this->getCanonicalLink() . '">';
		}

		// Add markup version
		if (!empty($this->getMarkupVersion())) {
			$headString .= '          <meta property="op:markup_version" content="' . $this->getMarkupVersion() . '">';
		}

		$headString .= '          <meta property="fb:use_automatic_ad_placement" content="' . Base::stringifyBoolean(
				$this->isUseAutomaticAdPlacement()
			) . '">';

		if (!empty($this->getArticleStyle())) {
			$headString .= '          <meta property="fb:article_style" content="' . $this->getArticleStyle() . '">';
		}

		if (!empty($this->getTags())) {
			$headString .= '          <meta property="op:tags" content="' . Base::arrayOrSeparatedString(
					$this->getTags(),
					self::RETURN_SEPARATED_STRING,
					';'
				) . '">';
		}

		$headString .= '        </' . $this->getRoot() . '>';

		return $headString;

	}

	/**
	 * @return string
	 */
	public function getCharset() {

		return $this->_charset;
	}

	/**
	 * @param string $charset
	 *
	 * @return Head
	 */
	public function setCharset($charset) {

		$this->_charset = $charset;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCanonicalLink() {

		return $this->_canonicalLink;
	}

	/**
	 * @param string $canonicalLink
	 *
	 * @return Head
	 */
	public function setCanonicalLink($canonicalLink) {

		$this->_canonicalLink = $canonicalLink;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMarkupVersion() {

		return $this->_markupVersion;
	}

	/**
	 * @param string $markupVersion
	 *
	 * @return Head
	 */
	public function setMarkupVersion($markupVersion) {

		$this->_markupVersion = $markupVersion;

		return $this;
	}

	/**
	 * isUseAutomaticAdPlacement
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  boolean    $_useAutomaticAdPlacement
	 */
	public function isUseAutomaticAdPlacement() {

		return $this->_useAutomaticAdPlacement;

	}

	/**
	 * setUseAutomaticAdPlacement
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   boolean $useAutomaticAdPlacement
	 *
	 * @return  Head
	 */
	public function setUseAutomaticAdPlacement($useAutomaticAdPlacement) {

		$this->_articleStyle = (boolean) $useAutomaticAdPlacement;

		return $this;

	}

	/**
	 * getArticleStyle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_articleStyle
	 */
	public function getArticleStyle() {

		return $this->_articleStyle;

	}

	/**
	 * setArticleStyle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $articleStyle
	 *
	 * @return  Head
	 */
	public function setArticleStyle($articleStyle) {

		if (empty($articleStyle)) {
			$this->_articleStyle = null;
		} else {
			$this->_articleStyle = (string) $articleStyle;
		}

		return $this;

	}

	/**
	 * getTags
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return array
	 */
	public function getTags() {

		return $this->_tags;

	}

	/**
	 * setTags
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array|string $tags array of tags or comma separated strings
	 * @param bool         $overwrite
	 *
	 * @return Head
	 */
	public function setTags($tags, $overwrite = true) {

		$tags = Base::arrayOrSeparatedString($tags);

		if ($overwrite) {
			$this->_tags = $tags;
		} else {
			$this->_tags = array_unique(array_merge($this->_tags, $tags));
		}

		return $this;

	}

}
