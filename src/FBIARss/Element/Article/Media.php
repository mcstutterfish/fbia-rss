<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Media
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Media extends Base {

	/**
	 * @var string
	 */
	protected $_mediaType = null;

	/**
	 * @var string
	 */
	protected $_root = 'figure';

	/**
	 * The source of the content for your Media. (required)
	 *
	 * @var string
	 */
	protected $_source = '';

	/**
	 * Represents audio annotation for this Media within your Instant Article.
	 *
	 * @var Audio
	 */
	protected $_audio = '';

	/**
	 * Descriptive text for your Media. May also include attribution to the originator or creator of this GIF.
	 *
	 * @var \FBIARss\Element\Article\Caption
	 */
	protected $_caption = '';

	/**
	 * Enables readers to like this Media.
	 *
	 * @var boolean
	 */
	protected $_likesEnabled = false;

	/**
	 * Enables readers to comment on this Media.
	 *
	 * @var boolean
	 */
	protected $_commentsEnabled = false;

	/**
	 * Enables readers to like and comment on this Media.
	 *
	 * @var string
	 */
	protected $_feedback = '';

	/**
	 * Specifies the geographic location for this Media.
	 *
	 * @var Location
	 */
	protected $_location = null;

	/**
	 * Defines the presentation style of the Media.
	 *
	 * @var string
	 */
	protected $_presentation = '';

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
			throw new \Exception('Source is required for all Medias');
		}

		$mediaString = '<' . $this->getRoot() . (!empty($this->getFeedback())
				? ' ' . $this->getFeedback()
				: '') . (!empty($this->getPresentation())
				? ' ' . $this->getPresentation()
				: '') . '>';
		$mediaString .= '<img src="' . $this->getSource() . '" />';

		if (!empty($this->getCaption())) {
			$mediaString .= $this->getCaption()
				->render();
		}

		if (!empty($this->getAudio())) {
			$mediaString .= $this->getAudio()
				->render();
		}

		if (!empty($this->getLocation())) {
			$mediaString .= $this->getLocation()
				->render();
		}

		$mediaString .= '</' . $this->getRoot() . '>';

		return $mediaString;

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
	 * @return Media
	 * @throws \Exception
	 */
	public function setSource($source) {

		if (!$this->isValidURL($source)) {
			throw new \Exception('source (' . $source . ') must be a valid URL for all media');
		}

		$this->_source = $source;

		return $this;

	}

	/**
	 * getFeedback
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param bool $wrapElement (wrap in data-feedback?)
	 *
	 * @return string
	 */
	public function getFeedback($wrapElement = false) {

		$feedbackEnabled = [];

		if ($this->isLikesEnabled()) {
			$feedbackEnabled[] = 'fb:likes';
		}

		if ($this->isCommentsEnabled()) {
			$feedbackEnabled[] = 'fb:comments';
		}

		if ($wrapElement) {

			if (!empty($feedbackEnabled)) {
				return 'data-feedback="' . implode(',', $feedbackEnabled) . '"';
			}

		} else {
			return implode(',', $feedbackEnabled);
		}

		return '';

	}

	/**
	 * isLikesEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  boolean    $_likesEnabled
	 */
	public function isLikesEnabled() {

		return $this->_likesEnabled;

	}

	/**
	 * setLikesEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   boolean $likesEnabled
	 *
	 * @return  Media
	 */
	public function setLikesEnabled($likesEnabled) {

		$this->_likesEnabled = (boolean) $likesEnabled;

		return $this;

	}

	/**
	 * isCommentsEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  boolean    $_commentsEnabled
	 */
	public function isCommentsEnabled() {

		return $this->_commentsEnabled;

	}

	/**
	 * setCommentsEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   boolean $commentsEnabled
	 *
	 * @return  Media
	 */
	public function setCommentsEnabled($commentsEnabled) {

		$this->_commentsEnabled = (boolean) $commentsEnabled;

		return $this;

	}

	/**
	 * getPresentation
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param bool $wrapElement (wrap in data-mode?)
	 *
	 * @return  string    $_presentation
	 */
	public function getPresentation($wrapElement = false) {

		if ($wrapElement && !empty($this->_presentation)) {
			return 'data-mode="' . $this->_presentation . '"';
		}

		return $this->_presentation;

	}

	/**
	 * setPresentation
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $presentation
	 *
	 * @return  Media
	 */
	public function setPresentation($presentation) {

		$this->_presentation = $this->_validPresentation($presentation);

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
	 * @return  Media
	 */
	public function setCaption(Caption $caption) {

		$this->_caption = $caption;

		return $this;

	}

	/**
	 * getAudio
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Audio    $_audio
	 */
	public function getAudio() {

		return $this->_audio;

	}

	/**
	 * setAudio
	 *
	 * Pass in a pre-setup audio object
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   Audio $audio
	 *
	 * @return  Media
	 */
	public function setAudio(Audio $audio) {

		$this->_audio = $audio;

		return $this;

	}

	/**
	 * getLocation
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Location    $_location
	 */
	public function getLocation() {

		return $this->_location;

	}

	/**
	 * setLocation
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $latitude
	 * @param string $longitude
	 * @param string $title
	 * @param string $radius
	 * @param string $pivot
	 * @param string $style
	 *
	 * @return Media
	 */
	public function setLocation($latitude,
		$longitude,
		$title = null,
		$radius = null,
		$pivot = null,
		$style = null) {

		$this->_location = new Location($latitude, $longitude, $title, $radius, $pivot, $style);

		return $this;

	}

	/**
	 * _validPresentation
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $presentation
	 *
	 * @return string
	 */
	protected function _validPresentation($presentation) {

		$validOptions = [
			'fit' => 'aspect-fit',
			'fit-only' => 'aspect-fit-only',
			'f' => 'aspect-fit',
			'fo' => 'aspect-fit-only',
			'fs' => 'fullscreen',
			'ni' => 'non-interactive',
		];

		$presentation = strtolower(trim($presentation));

		if (in_array($presentation, $validOptions)) {
			return $presentation;
		} elseif (array_key_exists($presentation, $validOptions)) {
			return $validOptions[$presentation];
		}

		return '';

	}

	/**
	 * createAudio
	 *
	 * Setup Audio object
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $source
	 * @param   string $playMode
	 * @param   string $title
	 *
	 * @return  Media
	 */
	public function createAudio($source, $playMode = null, $title = null) {

		return $this->setAudio(new Audio($source, $playMode, $title));

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
	 * @return Media
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
