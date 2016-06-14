<?php
namespace FBIARss\Element;

use FBIARss\SimpleXMLElement;

/**
 * Class Base
 *
 * @package FBIARss\Element
 *
 * @author  Christopher M. Black <cblack@devonium.com>
 *
 * @since   0.1.1
 * @version 0.1.5
 */
abstract class Base {

	const RETURN_ARRAY = 1;
	const RETURN_SEPARATED_STRING = 2;

	/**
	 * Default format example: 2015-10-20T09:45:00-05:00
	 *
	 * @var string
	 */
	protected static $_rssDateFormat = 'Y-m-d\TH:i:s\Z';

	/**
	 * Default format example: October 20th 2015
	 *
	 * @var string
	 */
	protected static $_displayDateFormat = 'F jS Y';

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
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   array|string    $check              array of strings or comma separated strings
	 * @param   integer         $returnType
	 * @param   string          $stringSeparator
	 *
	 * @return  array
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
	 * @since   0.1.1
	 * @version 0.1.5
	 *
	 * @param   null|int|string $date
	 *
	 * @return  boolean|string
	 */
	public static function formatRSSDate($date = null) {

		$date = self::isTimestamp($date)
			? $date
			: (!empty($date)
				? strtotime($date)
				: null);

		return gmdate(
			self::$_rssDateFormat,
			!is_null($date)
				? $date
				: time());

	}

	/**
	 * Checks if a string is a valid timestamp.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string  $timestamp  Timestamp to validate.
	 *
	 * @return  boolean
	 */
	public static function isTimestamp($timestamp) {

		$check = (is_int($timestamp) OR is_float($timestamp))
			? $timestamp
			: (string) (int) $timestamp;

		return ($check === $timestamp) AND ((int) $timestamp <= PHP_INT_MAX) AND ((int) $timestamp >= ~PHP_INT_MAX);

	}

	/**
	 * formatUserDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   null|int|string $date
	 *
	 * @return  boolean|string
	 */
	public static function formatUserDate($date = null) {

		$date = self::isTimestamp($date)
			? $date
			: (!empty($date)
				? strtotime($date)
				: null);

		return date(
			self::$_displayDateFormat,
			!is_null($date)
				? $date
				: time());

	}

	/**
	 * stringifyBoolean
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   boolean $value
	 *
	 * @return  string
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
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @return  string
	 */
	public function getStringSeparator() {

		return self::$_stringSeparator;

	}

	/**
	 * setStringSeparator
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string  $stringSeparator
	 *
	 * @return  Base
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
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string  $url
	 *
	 * @return  boolean
	 */
	public function isValidURL($url) {

		return filter_var($url, FILTER_VALIDATE_URL) !== false;

	}

	/**
	 * getRoot
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @return  string
	 */
	public function getRoot() {

		return $this->_root;

	}

	/**
	 * stripBeginEndParagraphs
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   string  $text
	 * @param   boolean $stripBeginning
	 * @param   boolean $stripEnding
	 *
	 * @return  string
	 */
	public function stripBeginEndParagraphs($text, $stripBeginning = true, $stripEnding = true) {

		$text = trim($text);
		$beginningPrefixes = ['<p>', '</p>'];
		$endingPrefixes = ['</p>', '<p>'];

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
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @param   SimpleXMLElement|null   $xmlElement
	 *
	 * @return  SimpleXMLElement|string
	 */
	abstract public function render(SimpleXMLElement $xmlElement = null);

}
