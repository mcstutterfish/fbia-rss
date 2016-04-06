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
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
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
	protected $_caption = '';

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
			throw new \Exception('Source is required for all Social Embeds');
		}

		$socialEmbedString = '<' . $this->getRoot() . ' class="op-social">';

		$iframeEnclosed = !$this->isValidURL($this->getSource());

		if ($iframeEnclosed) {
			$socialEmbedString .= '<iframe>' . $this->getSource() . '</iframe>';
		} else {
			$socialEmbedString .= '<iframe src="' . $this->getSource() . '"></iframe>';
		}

		if (!empty($this->getCaption())) {
			$socialEmbedString .= $this->getCaption()
				->render();
		}

		$socialEmbedString .= '</' . $this->getRoot() . '>';

		return $socialEmbedString;

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
	 * @return SocialEmbed
	 * @throws \Exception
	 */
	public function setSource($source) {

		$this->_source = $source;

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
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $title
	 * @param string $credit
	 * @param string $body
	 * @param string $positioning
	 * @param string $horizontalAlignment
	 * @param string $verticalAlignment
	 *
	 * @return SocialEmbed
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
