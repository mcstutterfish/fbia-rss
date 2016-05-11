<?php
namespace FBIARss\Element\Article;

use FBIARss\SimpleXMLElement;

/**
 * Class Video
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Video extends Media {

	/**
	 * @var string
	 */
	protected $_mediaType = 'Video';

	/**
	 * Specifies the playback mode for this video.
	 *
	 * @var string
	 */
	protected $_posterFrame = '';

	/**
	 * Specifies the visibility of the video player controls on this video.
	 *
	 * @var bool
	 */
	protected $_controlsEnabled = true;

	/**
	 * Specifies the looping behavior for this video.
	 *
	 * @var string
	 */
	protected $_loopMode = 'loop';

	/**
	 * Type of video
	 *
	 * @var string
	 */
	protected $_type = '';

	/**
	 * Specifies the playback mode for this video.
	 *
	 * @var boolean
	 */
	protected $_autoPlay = true;

	/**
	 * setControlsDisabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Video
	 */
	public function setControlsDisabled() {

		$this->_controlsEnabled = false;

		return $this;

	}

	/**
	 * setAutoPlayEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Video
	 */
	public function setAutoPlayEnabled() {

		$this->_autoPlay = true;

		return $this;

	}

	/**
	 * setAutoPlayDisabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Video
	 */
	public function setAutoPlayDisabled() {

		$this->_autoPlay = false;

		return $this;

	}

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
			throw new \Exception('Source is required for all Videos');
		}

		$type = '';

		if (empty($this->getType())) {
			$type = ' type="' . $this->getType() . '"';
		}

		$videoString = '<' . $this->getRoot() . (!empty($this->getFeedback())
				? ' ' . $this->getFeedback()
				: '') . (!empty($this->getPresentation())
				? ' ' . $this->getPresentation()
				: '') . '>';

		$playbackMode = $this->isAutoPlay()
			? ''
			: ' data-fb-disable-autoplay';
		$controls     = $this->isControlsEnabled()
			? ''
			: ' data-fb-disable-controls';

		$videoString .= '<video' . (!empty($this->getLoopMode())
				? ' ' . $this->getLoopMode()
				: '') . $playbackMode . $controls . '>';
		$videoString .= '<source src="' . $this->getSource() . '"' . $type . ' />';
		$videoString .= '</video>';

		$videoString .= $this->getPosterFrame(true);

		if (!empty($this->getCaption())) {
			$videoString .= $this->getCaption()->render();
		}

		if (!empty($this->getAudio())) {
			$videoString .= $this->getAudio()->render();
		}

		if (!empty($this->getLocation())) {
			$videoString .= $this->getLocation()->render();
		}

		$videoString .= '</' . $this->getRoot() . '>';

		return $videoString;

	}

	/**
	 * getType
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getType() {

		return $this->_type;

	}

	/**
	 * setType
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $type
	 *
	 * @return  Video
	 */
	public function setType($type) {

		$this->_type = $type;

		return $this;

	}

	/**
	 * getPlaybackMode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  boolean $_autoPlay
	 */
	public function isAutoPlay() {

		return $this->_autoPlay;

	}

	/**
	 * isControlsEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  boolean    $_controlsEnabled
	 */
	public function isControlsEnabled() {

		return $this->_controlsEnabled;

	}

	/**
	 * setControlsEnabled
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Video
	 */
	public function setControlsEnabled() {

		$this->_controlsEnabled = true;

		return $this;

	}

	/**
	 * getLoopMode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_loopMode
	 */
	public function getLoopMode() {

		return $this->_loopMode;

	}

	/**
	 * setLoopMode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $loopMode
	 *
	 * @return  Video
	 */
	public function setLoopMode($loopMode) {

		$validOptions = [
			'' => '', // allows setting empty value
			'loop' => 'loop',
			'fade' => 'data-fade',
		];

		if (in_array($loopMode, $validOptions)) {
			$this->_loopMode = $loopMode;
		} elseif (array_key_exists($loopMode, $validOptions)) {
			$this->_loopMode = $validOptions[$loopMode];
		}

		return $this;

	}

	/**
	 * getPosterFrame
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param bool $wrapElement (wrap in img tag)
	 *
	 * @return  string    $_posterFrame
	 */
	public function getPosterFrame($wrapElement = false) {

		if ($wrapElement && !empty($this->_posterFrame)) {
			return '<img src="' . $this->_posterFrame . '" />';
		}

		return $this->_posterFrame;

	}

	/**
	 * setPosterFrame
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $posterFrame
	 *
	 * @return Video
	 * @throws \Exception
	 */
	public function setPosterFrame($posterFrame) {

		if (!$this->isValidURL($posterFrame)) {
			throw new \Exception('source (' . $posterFrame . ') must be a valid URL for all videos');
		}

		$this->_posterFrame = $posterFrame;

		return $this;

	}

}
