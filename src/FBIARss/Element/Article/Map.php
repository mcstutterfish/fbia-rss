<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Map
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @version     0.1.1
 * @since       0.1.4
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 */
class Map extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'figure';

	/**
	 * Represents audio annotation for this map within your Instant Article.
	 *
	 * @var Audio
	 */
	protected $_audio = '';

	/**
	 * Descriptive text for your map.
	 *
	 * @var \FBIARss\Element\Article\Caption
	 */
	protected $_caption = '';

	/**
	 * Location for the pin on your map. (required)
	 *
	 * @var Location
	 */
	protected $_location = null;

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
		if (empty($this->getLocation())) {
			throw new \Exception('Location is required for all Maps');
		}

		$mapString = '<' . $this->getRoot() . ' class="op-map">';

		if (!empty($this->getCaption())) {
			$mapString .= $this->getCaption()->render();
		}

		if (!empty($this->getAudio())) {
			$mapString .= $this->getAudio()->render();
		}

		if (!empty($this->getLocation())) {
			$mapString .= $this->getLocation()->render();
		}

		$mapString .= '</' . $this->getRoot() . '>';

		return $mapString;

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
	 * @return Map
	 */
	public function setLocation($latitude, $longitude, $title = null, $radius = null, $pivot = null, $style = null) {

		$this->_location = new Location($latitude, $longitude, $title, $radius, $pivot, $style);

		return $this;

	}

	/**
	 * getCaption
	 *
	 * @since   0.1.1
	 * @version 0.1.1
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
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   Caption $caption
	 *
	 * @return  Map
	 */
	public function setCaption(Caption $caption) {

		$this->_caption = $caption;

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
	 * @return  Map
	 */
	public function setAudio(Audio $audio) {

		$this->_audio = $audio;

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
	 * @return  Map
	 */
	public function createAudio($source, $playMode = null, $title = null) {

		return $this->setAudio(new Audio($source, $playMode, $title));

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
	 * @return Map
	 */
	public function createCaption($options = []) {

		return $this->setCaption(new Caption($options));

	}

}
