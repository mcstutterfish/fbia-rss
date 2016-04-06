<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Footer
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Footer extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'footer';

	/**
	 * The credits for this article.
	 *
	 * @var array
	 */
	protected $_credits = [];

	/**
	 * The copyright details for this article.
	 *
	 * @var string
	 */
	protected $_copyright = '';

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
		if (empty($this->getCredits()) || empty($this->getCopyright())) {
			throw new \Exception('Either Copyright or Credits are required for all footers');
		}

		$footerString = '<' . $this->getRoot() . '>';
		if (!empty($this->getCopyright())) {
			$footerString .= '<small>' . $this->getCopyright() . '</small>';
		}

		$credits = $this->getCredits();

		if (!empty($credits)) {
			$footerString .= '<aside>';
			if (count($credits) > 1) {
				foreach ($credits as $credit) {
					$footerString .= "<p>{$credit}</p>";
				}
			} else {
				$footerString .= $credits[0];
			}
		}

		$footerString .= '</' . $this->getRoot() . '>';

		return $footerString;

	}

	/**
	 * getCredits
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  array    $_credits
	 */
	public function getCredits() {

		return array_filter($this->_credits);

	}

	/**
	 * setCredits
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array|string $credits
	 * @param bool         $overwriteArray overwrite when array?
	 *
	 * @return Footer
	 */
	public function setCredits($credits, $overwriteArray = true) {

		if (is_array($credits)) {
			if ($overwriteArray) {
				$this->_credits = $credits;
			} else {
				$this->_credits = array_merge($this->_credits, $credits);
			}
		} else {
			$this->_credits[] = $credits;
		}

		return $this;

	}

	/**
	 * getCopyright
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_copyright
	 */
	public function getCopyright() {

		return $this->_copyright;

	}

	/**
	 * setCopyright
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $copyright
	 *
	 * @return  Footer
	 */
	public function setCopyright($copyright) {

		$this->_copyright = $copyright;

		return $this;

	}

}
