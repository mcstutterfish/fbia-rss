<?php
namespace FBIARss\Element;

use FBIARss\Element\Article\Header;
use FBIARss\SimpleXMLElement;

/**
 * Class Article
 *
 * @package     FBIARss\Element
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Article extends Base {

	/**
	 * @var array
	 */
	private static $_articleElementClassNames = [
		'author' => 'Author',
		'header' => 'Header',
		'html' => 'Html',
	];

	/**
	 * whether to render the atricle with buuilt-in elements or to assume the __contentEncoded is already formatted
	 *
	 * @var bool
	 */
	protected $_autoRender = true;

	/**
	 * @var null|Head
	 */
	protected $_head = null;

	/**
	 * @var null|Header
	 */
	protected $_header = null;

	/**
	 * The headline of the article. (required)
	 *
	 * @var string
	 */
	protected $_title = '';

	/**
	 * The canonical URL for this article on your site. (required)
	 *
	 * @var string
	 */
	protected $_link = '';

	/**
	 * A string that provides a unique identifier for this article in your feed.
	 *
	 * @var string
	 */
	protected $_guid = '';

	/**
	 * A summary of your article, in plain text form.
	 *
	 * @var string
	 */
	protected $_description = '';

	/**
	 * The date of the article’s publication, in ISO-8601 format. (auto-formatted internally)
	 *
	 * @var string
	 */
	protected $_pubDate = '';

	/**
	 * Name(s) of the person who wrote the article.
	 *
	 * @var array
	 */
	protected $_authors = [];

	/**
	 * @var array
	 */
	private $__elements = [];

	/**
	 * The full content of your article, in HTML form. Remember to escape all HTML content by wrapping it within a CDATA section. (required)
	 *
	 * @var string
	 */
	private $__contentEncoded = '';

	/**
	 * @var string
	 */
	private $__docRoot = 'article';

	/**
	 * ArticleItem constructor.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 */
	public function __construct() {

		$this->_head = new Head();
		$this->_header = new Header();

	}

	/**
	 * createElement
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $elementName
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public static function createElement($elementName) {

		$elementName = strtolower($elementName);

		if (!array_key_exists($elementName, self::$_articleElementClassNames)) {
			throw new \Exception("Invalid article element: {$elementName} does not exist!");
		}

		$className = __NAMESPACE__ . '\\Article\\' . self::$_articleElementClassNames[$elementName];

		if (!class_exists($className)) {
			throw new \Exception("Class {$className} does not exist!");
		}

		return new $className();

	}

	/**
	 * attachElement
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param mixed $element
	 *
	 * @return Article
	 */
	public function attachElement($element) {

		$this->__elements[] = $element;

		return $this;

	}

	/**
	 * getHead
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return Head
	 */
	public function getHead() {

		return $this->_head;

	}

	/**
	 * getHeader
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return Header
	 */
	public function getHeader() {

		return $this->_header;

	}

	/**
	 * getAuthors
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return array
	 */
	public function getAuthors() {

		return $this->_authors;

	}

	/**
	 * setAuthors
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array $authors
	 *
	 * @return Article
	 */
	public function setAuthors(array $authors) {

		$this->_authors = $authors;

		return $this;

	}

	/**
	 * setAuthor
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $author
	 * @param bool   $clear
	 *
	 * @return Article
	 */
	public function setAuthor($author, $clear = false) {

		if ($clear) {
			$this->_authors = [$author];
		} else {
			$this->_authors[] = $author;
		}

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
	 * @return Article
	 */
	public function setTitle($title) {

		$this->_title = $title;

		return $this;

	}

	/**
	 * getLink
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getLink() {

		return $this->_link;

	}

	/**
	 * setLink
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $link
	 *
	 * @return Article
	 */
	public function setLink($link) {

		$this->_link = $link;

		return $this;

	}

	/**
	 * getGuid
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getGuid() {

		return $this->_guid;

	}

	/**
	 * setGuid
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $guid
	 *
	 * @return Article
	 */
	public function setGuid($guid) {

		$this->_guid = $guid;

		return $this;

	}

	/**
	 * getDescription
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getDescription() {

		return $this->_description;

	}

	/**
	 * setDescription
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $description
	 *
	 * @return Article
	 */
	public function setDescription($description) {

		$this->_description = $description;

		return $this;

	}

	/**
	 * getPubDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getPubDate() {

		return $this->_pubDate;

	}

	/**
	 * setPubDate
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string|int $pubDate
	 *
	 * @return Article
	 */
	public function setPubDate($pubDate) {

		$this->_pubDate = Base::formatRSSDate($pubDate);

		return $this;

	}

	/**
	 * getContentEncoded
	 *
	 * returns the encoded article string
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getContentEncoded() {

		return $this->__contentEncoded;

	}

	/**
	 * setContentEncoded
	 *
	 * Allows for manually setting the instant articles encoded article instead of generating with package methods
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $_contentEncoded
	 *
	 * @return Article
	 */
	public function setContentEncoded($_contentEncoded) {

		$this->_autoRender      = false;
		$this->__contentEncoded = $_contentEncoded;

		return $this;

	}

	/**
	 * render
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param SimpleXMLElement $xmlElement
	 *
	 * @return SimpleXMLElement
	 * @throws \Exception
	 */
	public function render(SimpleXMLElement $xmlElement = null) {

		$this->_xmlElement = $xmlElement;

		if (!is_a($this->_xmlElement, 'SimpleXMLElement')) {
			throw new \Exception('render must be passed an object of type SimpleXMLElement');
		}

		if ($this->_autoRender) {
			// render the article so we can be sure everything is ok before adding items to the XML doc
			$this->_renderArticle();
		}

		if (empty($this->_title)) {
			throw new \Exception('title is required for all articles');
		} else {
			$this->_xmlElement->addChild('title', $this->_title);
		}

		if (empty($this->_link)) {
			throw new \Exception('link is required for all articles');
		} else {
			$this->_xmlElement->addChild('link', $this->_link);
		}

		if (!empty($this->_guid)) {
			$this->_xmlElement->addChild('guid', $this->_guid);
		}

		if (!empty($this->_description)) {
			$this->_xmlElement->addChild('description', $this->_description);
		}

		if (!empty($this->_pubDate)) {
			$this->_xmlElement->addChild('pubDate', $this->_pubDate);
		}

		if (!empty($this->_authors)) {
			foreach ($this->_authors as $author) {
				$this->_xmlElement->addChild('author', $author);
			}
		}

		// generate article and attach to document
		$this->_xmlElement->addCdataChild('content:encoded', $this->__contentEncoded);

		return $this->_xmlElement;

	}

	/**
	 * _renderArticle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return void
	 */
	protected function _renderArticle() {

		$this->__contentEncoded = '<!doctype html>';
		$this->__contentEncoded .= '  <html lang="en" prefix="op: http://media.facebook.com/op#">';
		$this->__contentEncoded .= $this->_head->render();
		$this->__contentEncoded .= '    <body>';
		$this->__contentEncoded .= '      <' . $this->__docRoot . '>';

		// Header

		// Article content / elements

		// Footer

		$this->__contentEncoded .= '      </' . $this->__docRoot . '>';
		$this->__contentEncoded .= '    </body>';
		$this->__contentEncoded .= '  </html>';

	}
}
