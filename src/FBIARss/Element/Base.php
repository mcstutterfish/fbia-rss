<?php
namespace FBIARss\Element;

use FBIARss\SimpleXMLElement;

/**
 * Class Base
 *
 * @package     FBIARss\Element
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
abstract class Base {

	const RETURN_ARRAY = 1;
	const RETURN_SEPARATED_STRING = 2;

	/**
	 * @var string
	 */
	protected static $_rssDateFormat = 'D, d M Y H:i:s O';

	/**
	 * @var string
	 */
	protected static $_displayDateFormat = 'r';

	/**
	 * @var string
	 */
	protected static $_stringSeparator = ',';

	/**
	 * @var SimpleXMLElement
	 */
	protected $_xmlElement;

	/**
	 * XML or HTML root element
	 *
	 * @var string
	 */
	protected $_root = '';

	/**
	 * arrayOrSeparatedString
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array|string $check array of strings or comma separated strings
	 * @param int          $returnType
	 * @param string       $stringSeparator
	 *
	 * @return array
	 */
	public static function arrayOrSeparatedString($check, $returnType = self::RETURN_ARRAY, $stringSeparator = null) {

		$return = [];

		$stringSeparator = is_null($stringSeparator)
			? self::$_stringSeparator
			: $stringSeparator;

		if (is_array($check)) {
			$return = $check;
		} elseif (!empty($check)) {
			$return = explode($stringSeparator, $check);
		}

		$return = array_unique($return);;

		switch ($returnType) {

			case self::RETURN_SEPARATED_STRING:
				return implode($stringSeparator, $return);
				break;

			case self::RETURN_ARRAY:
			default:

				return $return;

		}

	}

	/**
	 * formatRSSDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param null|int|string $date
	 *
	 * @return bool|string
	 */
	public static function formatRSSDate($date = null) {

		return date(
			self::$_rssDateFormat,
			!is_null($date)
				? strtotime($date)
				: time()
		);

	}

	/**
	 * formatUserDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param null|int|string $date
	 *
	 * @return bool|string
	 */
	public static function formatUserDate($date = null) {

		return date(
			self::$_displayDateFormat,
			!is_null($date)
				? strtotime($date)
				: time()
		);

	}

	/**
	 * stringifyBoolean
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param boolean $value
	 *
	 * @return string
	 */
	public static function stringifyBoolean($value) {

		return $value
			? 'true'
			: 'false';

	}

	/**
	 * getStringSeparator
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getStringSeparator() {

		return self::$_stringSeparator;

	}

	/**
	 * setStringSeparator
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $stringSeparator
	 *
	 * @return Base
	 */
	public function setStringSeparator($stringSeparator) {

		self::$_stringSeparator = $stringSeparator;

		return $this;

	}

	/**
	 * isValidURL
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $url
	 *
	 * @return boolean
	 */
	public function isValidURL($url) {

		return (bool) parse_url($url);

	}

	/**
	 * getRoot
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getRoot() {

		return $this->_root;

	}

	/**
	 * stripBeginEndParagraphs
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $text
	 * @param bool $stripBeginning
	 * @param bool $stripEnding
	 *
	 * @return string
	 */
	public function stripBeginEndParagraphs($text, $stripBeginning = true, $stripEnding = true) {

		$beginningPrefixes = ['<p>', '</p>'];
		$endingPrefixes    = ['</p>', '<p>'];

		if ($stripBeginning) {
			foreach ($beginningPrefixes as $beginningPrefix) {
				$text = preg_replace('/^' . preg_quote($beginningPrefix, '/') . '/i', '', $text);
			}
		}

		if ($stripEnding) {
			foreach ($endingPrefixes as $endingPrefix) {
				$text = preg_replace('/' . preg_quote($endingPrefix, '/') . '$/i', '', $text);
			}
		}

		return $text;

	}

	/**
	 * render
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param SimpleXMLElement $xmlElement
	 *
	 * @return SimpleXMLElement|string
	 */
	abstract public function render(SimpleXMLElement $xmlElement = null);

}
