<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Article;
use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Header
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Header extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'header';

	/**
	 * The title of the article. (required)
	 *
	 * @var string
	 */
	protected $_title = '';

	/**
	 * A subtitle for the article.
	 *
	 * @var string
	 */
	protected $_subTitle = '';

	/**
	 * One or more Author elements, defining the contributors to this article.
	 *
	 * @var \FBIARss\Element\Article\Author[]
	 */
	protected $_authors = [];

	/**
	 * A tertiary blurb in the headline of the article.
	 *
	 * @var string
	 */
	protected $_kicker = '';

	/**
	 * A tertiary blurb in the headline of the article.
	 *
	 * @var string
	 */
	protected $_modifiedDate = null;

	/**
	 * A tertiary blurb in the headline of the article.
	 *
	 * @var string
	 */
	protected $_publishedDate = null;

	/**
	 * The media to be displayed at the top of your article.
	 *
	 * @var \FBIARss\Element\Article\Image|\FBIARss\Element\Article\Video
	 */
	protected $_media = null;

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

		$headerString = '        <' . $this->getRoot() . '>';

		// add media
		if (!empty($this->getMedia())) {
			$headerString .= $this->getMedia()->render();
		}

		// Add title
		if (empty($this->getTitle())) {
			throw new \Exception('title is required for all articles');
		} else {
			$headerString .= '        <h1>' . $this->getTitle() . '</h1>';
		}

		// Add subtitle
		if (!empty($this->getSubTitle())) {
			$headerString .= '        <h2>' . $this->getSubTitle() . '</h2>';
		}

		// add kicker
		if (!empty($this->getKicker())) {
			$headerString .= '        <h3 class="op-kicker">' . $this->getKicker() . '</h3>';
		}

		// look and add authors if present
		if (!empty($this->getAuthors())) {
			foreach ($this->getAuthors() as $author) {
				$headerString .= $author->render();
			}
		}

		if (!empty($this->getModifiedDate())) {
			$headerString .= '          <time class="op-modified" dateTime="' . Base::formatRSSDate(
					$this->getModifiedDate()
				) . '">' . Base::formatUserDate($this->getModifiedDate()) . '</time>';
		}

		if (!empty($this->getPublishedDate())) {
			$headerString .= '          <time class="op-published" dateTime="' . Base::formatRSSDate(
					$this->getPublishedDate()
				) . '">' . Base::formatUserDate($this->getPublishedDate()) . '</time>';
		}

		$headerString .= '        </' . $this->getRoot() . '>';

		return $headerString;

	}

	/**
	 * getMedia
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Image|Video    $_media
	 */
	public function getMedia() {

		return $this->_media;

	}

	/**
	 * setMedia
	 *
	 * set pre-configured media object for header
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   Image|Video $media
	 *
	 * @return  Header
	 */
	public function setMedia($media) {

		$this->_media = $media;

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
	 * @return  Header
	 */
	public function setTitle($title) {

		$this->_title = $title;

		return $this;

	}

	/**
	 * getSubTitle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_subTitle
	 */
	public function getSubTitle() {

		return $this->_subTitle;

	}

	/**
	 * setSubTitle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $subTitle
	 *
	 * @return  Header
	 */
	public function setSubTitle($subTitle) {

		$this->_subTitle = $subTitle;

		return $this;

	}

	/**
	 * getKicker
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_kicker
	 */
	public function getKicker() {

		return $this->_kicker;

	}

	/**
	 * setKicker
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $kicker
	 *
	 * @return  Header
	 */
	public function setKicker($kicker) {

		$this->_kicker = $kicker;

		return $this;

	}

	/**
	 * getAuthors
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  Author[]    $_authors
	 */
	public function getAuthors() {

		return $this->_authors;

	}

	/**
	 * setAuthors
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   Author[] $authors
	 *
	 * @return  Header
	 */
	public function setAuthors($authors) {

		$this->_authors = $authors;

		return $this;

	}

	/**
	 * getModifiedDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_modifiedDate
	 */
	public function getModifiedDate() {

		return $this->_modifiedDate;

	}

	/**
	 * setModifiedDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string|int $modifiedDate
	 *
	 * @return  Header
	 */
	public function setModifiedDate($modifiedDate) {

		$this->_modifiedDate = strtotime($modifiedDate);

		if (is_null($this->_publishedDate)) {
			$this->_publishedDate = $this->_modifiedDate;
		}

		return $this;

	}

	/**
	 * getPublishedDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_publishedDate
	 */
	public function getPublishedDate() {

		return $this->_publishedDate;

	}

	/**
	 * setPublishedDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $publishedDate
	 *
	 * @return  Header
	 */
	public function setPublishedDate($publishedDate) {

		$this->_publishedDate = strtotime($publishedDate);

		if (is_null($this->_modifiedDate)) {
			$this->_modifiedDate = $this->_publishedDate;
		}

		return $this;

	}

	/**
	 * setAuthor
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $name
	 * @param bool   $clear
	 *
	 * @return Article
	 */
	public function setAuthor($name, $role = null, $contribution = null, $bio = null, $clear = false) {

		/**
		 * @var Author $author
		 */
		$author = Article::createElement('author');
		$author->setName($name)
			->setRole($role)
			->setContribution($contribution)
			->setBio($bio);

		if ($clear) {
			$this->_authors = [$author];
		} else {
			$this->_authors[] = $author;
		}

		return $this;

	}

}
