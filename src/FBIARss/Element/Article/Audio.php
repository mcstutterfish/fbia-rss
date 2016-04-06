<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Audio
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Audio extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'audio';

	/**
	 * The source of the audio. (required)
	 *
	 * @var string
	 */
	protected $_source = '';

	/**
	 * The title of this audio annotation.
	 *
	 * @var string
	 */
	protected $_title = '';

	/**
	 * Defines the playback experience for the auto annotation.
	 *
	 * @var string
	 */
	protected $_playMode = '';

	/**
	 * @var array
	 */
	private $__validPlayModes = [
		'autoplay',
		'muted'
	];

	/**
	 * Audio constructor.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $source
	 * @param   string $playMode
	 * @param   string $title
	 */
	public function __construct($source = null, $playMode = null, $title = null) {

		if (!is_null($source)) {

			$this->setSource($source);

			if (!empty($playMode)) {
				$this->setPlayMode($playMode);
			}

			if (!empty($title)) {
				$this->setTitle($title);
			}

		}

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
			throw new \Exception('source is required for all audio');
		}

		if (!$this->isValidURL($this->getSource())) {
			throw new \Exception('source (' . $this->getSource() . ') must be a valid URL for all audio');
		}

		$playMode = '';

		if (!empty($this->getPlayMode())) {
			$playMode = ' ' . $this->getPlayMode();
		}

		$title = '';

		if (!empty($this->getTitle())) {
			$title = ' title="' . htmlspecialchars($this->getTitle()) . '"';
		}

		$audioString = '<' . $this->getRoot() . $playMode . $title . '>';
		$audioString .= '<source src="' . $this->getSource() . '">';
		$audioString .= '</' . $this->getRoot() . '>';

		return $audioString;

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
	 * @return  Audio
	 */
	public function setSource($source) {

		$this->_source = $source;

		return $this;

	}

	/**
	 * getPlayMode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_playMode
	 */
	public function getPlayMode() {

		return $this->_playMode;

	}

	/**
	 * setPlayMode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $playMode
	 *
	 * @return Audio
	 * @throws \Exception
	 */
	public function setPlayMode($playMode) {

		$playMode = strtolower(trim($playMode));

		if (in_array($playMode, $this->__validPlayModes)) {
			$this->_playMode = $playMode;
		} else {
			throw new \Exception("Invalid play mode {$playMode}");
		}

		return $this;

	}

	/**
	 * getTitle
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
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $title
	 *
	 * @return  Audio
	 */
	public function setTitle($title) {

		$this->_title = $title;

		return $this;

	}

	/**
	 * setMuted
	 *
	 * Helper function to set audio to a muted play mode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return Audio
	 */
	public function setMuted() {

		$this->_playMode = 'muted';

		return $this;

	}

	/**
	 * setAutoPlay
	 *
	 * Helper function to set audio to an autoplay play mode
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return Audio
	 */
	public function setAutoPlay() {

		$this->_playMode = 'autoplay';

		return $this;

	}

}
