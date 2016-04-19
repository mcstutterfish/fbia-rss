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
 * @since       0.1.1
 * @version     0.1.2
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @uses        FBIARss\Element\Base
 * @uses        FBIARss\SimpleXMLElement
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
	 * Descriptive text for your Media. May also include attribution to the originator or creator of this media.
	 *
	 * @var \FBIARss\Element\Article\Caption[]
	 */
	protected $_captions = [];

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
	 * Media constructor.
	 *
	 * @since   0.1.2
	 * @version 0.1.2
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string       $source
	 * @param   boolean|null $likesEnabled
	 * @param   boolean|null $commentsEnabled
	 * @param   string       $presentation
	 */
	public function __construct($source = null, $likesEnabled = null, $commentsEnabled = null, $presentation = null) {

		if (!is_null($source)) {

			$this->setSource($source);

			if (is_bool($likesEnabled)) {
				$this->setLikesEnabled($likesEnabled);
			}

			if (is_bool($commentsEnabled)) {
				$this->setCommentsEnabled($commentsEnabled);
			}

			if (!empty($presentation)) {
				$this->setPresentation($presentation);
			}

		}

	}

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
			throw new \Exception('Source is required for all Medias');
		}

		$mediaString = '<' . $this->getRoot() . (!empty($this->getFeedback())
				? ' ' . $this->getFeedback()
				: '') . (!empty($this->getPresentation())
				? ' ' . $this->getPresentation()
				: '') . '>';
		$mediaString .= '<img src="' . $this->getSource() . '" />';

		if (!empty($this->getCaptions())) {
			foreach ($this->getCaptions() as $caption) {
				$mediaString .= $caption->render();
			}
		}

		if (!empty($this->getAudio())) {
			$mediaString .= $this->getAudio()->render();
		}

		if (!empty($this->getLocation())) {
			$mediaString .= $this->getLocation()->render();
		}

		$mediaString .= '</' . $this->getRoot() . '>';

		return $mediaString;

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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * getAudio
	 *
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * createAudio
	 *
	 * Setup Audio object
	 *
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * getCaptions
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Caption    $_captions
	 */
	public function getCaptions() {

		return $this->_captions;

	}

	/**
	 * setCaption
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   Caption $caption
	 * @param   boolean $append
	 *
	 * @return  Interactive
	 */
	public function setCaption(Caption $caption, $append = true) {

		if ($append) {
			$this->_captions[] = $caption;
		} else {
			$this->_captions = [$caption];
		}

		return $this;

	}

	/**
	 * _validPresentation
	 *
	 * @since   0.1.1
	 * @version 0.1.1
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

}
