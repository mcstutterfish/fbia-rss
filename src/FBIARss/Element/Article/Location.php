<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Location
 *
 * Specifies the geographic location for an element
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Location extends Base {

	/**
	 * @var string
	 */
	protected $_root = '';

	/**
	 * the latitude of the point's location. (required)
	 *
	 * @var float
	 */
	protected $_latitude = null;

	/**
	 * the longitude of the point's location. (required)
	 *
	 * @var float
	 */
	protected $_longitude = null;

	/**
	 * the name of the point's location
	 *
	 * @var string
	 */
	protected $_title = null;

	/**
	 * the radius of the map boundary
	 *
	 * @var integer
	 */
	protected $_radius = null;

	/**
	 * a boolean value indicating whether the point is centered for the geotag view
	 *
	 * @var boolean
	 */
	protected $_pivot = null;

	/**
	 * the type of map style to use for this location. This property can be set to hybrid or satellite.
	 *
	 * @var string
	 */
	protected $_style = null;

	/**
	 * Location constructor.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $latitude
	 * @param string $longitude
	 * @param string $title
	 * @param string $radius
	 * @param string $pivot
	 * @param string $style
	 */
	public function __construct($latitude = null,
		$longitude = null,
		$title = null,
		$radius = null,
		$pivot = null,
		$style = null) {

		if (!is_null($latitude) && !is_null($longitude)) {

			$this->setLatitude($latitude)
				->setLongitude($longitude);

			if (!empty($title)) {
				$this->setTitle($title);
			}

			if (!empty($radius)) {
				$this->setRadius($radius);
			}

			if (is_bool($pivot)) {
				$this->setPivot($title);
			}

			$style = strtolower(trim($style));

			if (!empty($style)) {
				$this->setStyle($style);
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
		if (empty($this->getLatitude()) || empty($this->getLongitude())) {
			throw new \Exception('latitude and longitude are required for all locations');
		}

		$locationArray = [
			'type' => 'Feature',
			'geometry' => [
				'type' => 'Point',
				'coordinates' => [
					$this->getLatitude(),
					$this->getLongitude()
				]
			]
		];

		if (!empty($this->getTitle()) || !empty($this->getRadius()) || !is_null($this->isPivot()) || !empty($this->getStyle())) {

			$locationArray['properties'] = [];

			if (!empty($this->getTitle())) {
				$locationArray['properties']['title'] = $this->getTitle();
			}

			if (!empty($this->getRadius())) {
				$locationArray['properties']['radius'] = $this->getRadius();
			}

			if (!is_null($this->isPivot())) {
				$locationArray['properties']['pivot'] = $this->isPivot();
			}

			if (!empty($this->getStyle())) {
				$locationArray['properties']['style'] = $this->getStyle();
			}

		}

		$locationString = '<script type="application/json" class="op-geotag">';

		$locationString .= json_encode($locationArray);

		$locationString .= '</script>';

		return $locationString;

	}

	/**
	 * getLatitude
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return float
	 */
	public function getLatitude() {

		return $this->_latitude;

	}

	/**
	 * setLatitude
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param float $latitude
	 *
	 * @return Location
	 */
	public function setLatitude($latitude) {

		$this->_latitude = floatval($latitude);

		return $this;

	}

	/**
	 * getLongitude
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return float
	 */
	public function getLongitude() {

		return $this->_longitude;

	}

	/**
	 * setLongitude
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param float $longitude
	 *
	 * @return Location
	 */
	public function setLongitude($longitude) {

		$this->_longitude = floatval($longitude);

		return $this;

	}

	/**
	 * getTitle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getTitle() {

		return $this->_title;

	}

	/**
	 * setTitle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $title
	 *
	 * @return Location
	 */
	public function setTitle($title) {

		$this->_title = (string) $title;

		return $this;

	}

	/**
	 * getRadius
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return int
	 */
	public function getRadius() {

		return $this->_radius;

	}

	/**
	 * setRadius
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param int $radius
	 *
	 * @return Location
	 */
	public function setRadius($radius) {

		$this->_radius = intval($radius);

		return $this;

	}

	/**
	 * isPivot
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return boolean
	 */
	public function isPivot() {

		return $this->_pivot;

	}

	/**
	 * setPivot
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param boolean $pivot
	 *
	 * @return Location
	 */
	public function setPivot($pivot) {

		$this->_pivot = is_bool($pivot)
			? $pivot
			: null;

		return $this;

	}

	/**
	 * getStyle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getStyle() {

		return $this->_style;

	}

	/**
	 * setStyle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $style
	 *
	 * @return Location
	 */
	public function setStyle($style) {

		if (in_array($style, ['hybrid', 'satellite'])) {
			$this->_style = $style;
		}

		return $this;

	}

}
