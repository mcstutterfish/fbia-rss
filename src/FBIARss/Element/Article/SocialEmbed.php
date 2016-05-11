<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class SocialEmbed
 *
 * Embed:
 *      - Instagram
 *      - Facebook
 *      - Twitter
 *      - Vine
 *      - YouTube
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @since       0.1.1
 * @version     0.1.4
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 */
class SocialEmbed extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'figure';

	/**
	 * The source of the content for your social embed. (required)
	 *
	 * @var string
	 */
	protected $_source = '';

	/**
	 * Descriptive text for your social embed.
	 *
	 * @var \FBIARss\Element\Article\Caption
	 */
	protected $_caption = null;

	/**
	 * render
	 *
	 * @since   0.1.1
	 * @version 0.1.4
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
			throw new \Exception('Source is required for all Social Embeds');
		}

		$socialEmbedString = '<' . $this->getRoot() . ' class="op-social">';

		$iframeEnclosed = !$this->isValidURL($this->getSource());

		if ($iframeEnclosed) {
			$socialEmbedString .= $this->getSource();
		} else {
			$socialEmbedString .= '<iframe src="' . $this->getSource() . '"></iframe>';
		}

		if (!empty($this->getCaption())) {
			$socialEmbedString .= $this->getCaption()->render();
		}

		$socialEmbedString .= '</' . $this->getRoot() . '>';

		return $socialEmbedString;

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
	 * @return SocialEmbed
	 * @throws \Exception
	 */
	public function setSource($source) {

		$this->_source = $source;

		return $this;

	}

	/**
	 * getCaptions
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
	 * @return  SocialEmbed
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
	 * @return Caption
	 */
	public function createCaption($options = []) {

		return $this->setCaption(new Caption($options));

	}

}
