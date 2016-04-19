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
 * @since       0.1.1
 * @version     0.1.2
 */
class Article extends Base {

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
	private $__articleElementClassNames = [
		'ad' => 'Ad',
		'analytics' => 'Analytics',
		'audio' => 'Audio',
		'author' => 'Author',
		'blockquote' => 'BlockQuote',
		'bodytext' => 'BodyText',
		'caption' => 'Caption',
		'footer' => 'Footer',
		'header' => 'Header',
		'html' => 'Html',
		'image' => 'Image',
		'interactive' => 'Interactive',
		'listing' => 'Listing',
		'location' => 'Location',
		'map' => 'Map',
		'pullquote' => 'PullQuote',
		'relatedarticles' => 'RelatedArticles',
		'slideshow' => 'SlideShow',
		'socialembed' => 'SocialEmbed',
		'video' => 'Video'
	];

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

		$this->_head   = new Head();
		$this->_header = new Header();

	}

	/**
	 * createElement
	 *
	 * @since   0.1.1
	 * @version 0.1.2
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string  $elementName
	 * @param boolean $attachElement
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function createElement($elementName, $attachElement = true) {

		$elementName = strtolower($elementName);

		if (!array_key_exists($elementName, $this->__articleElementClassNames)) {
			throw new \Exception("Invalid article element: {$elementName} does not exist!");
		}

		$className = __NAMESPACE__ . '\\Article\\' . $this->__articleElementClassNames[$elementName];

		if (!class_exists($className)) {
			throw new \Exception("Class {$className} does not exist!");
		}

		$element = new $className();

		if ($attachElement) {
			$this->attachElement($element);
		}

		return $element;

	}

	/**
	 * attachElement
	 *
	 * attach an externally configured article element
	 *
	 * @since   0.1.1
	 * @version 0.1.2
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   mixed $element
	 *
	 * @return  Article
	 */
	public function attachElement($element) {

		$this->__elements[] = $element;

		return $this;

	}

	/**
	 * setTags
	 *
	 * helper to set the tags in the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array|string $tags array of tags or comma separated strings
	 * @param bool         $overwrite
	 *
	 * @return Article
	 */
	public function setTags($tags, $overwrite = true) {

		$this->getHead()->setTags($tags, $overwrite);

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
	 * getCanonicalLink
	 *
	 * helper to get the canonical link from the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getCanonicalLink() {

		return $this->getHead()->getCanonicalLink();

	}

	/**
	 * isUseAutomaticAdPlacement
	 *
	 * helper to get the status of using automatic ad placement from the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  boolean
	 */
	public function isUseAutomaticAdPlacement() {

		return $this->getHead()->isUseAutomaticAdPlacement();

	}

	/**
	 * setUseAutomaticAdPlacement
	 *
	 * helper to set the status of using automatic ad placement in the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   boolean $useAutomaticAdPlacement
	 *
	 * @return  Article
	 */
	public function setUseAutomaticAdPlacement($useAutomaticAdPlacement) {

		$this->getHead()->setUseAutomaticAdPlacement($useAutomaticAdPlacement);

		return $this;

	}

	/**
	 * getArticleStyle
	 *
	 * helper to get the article style from the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getArticleStyle() {

		return $this->getHead()->getArticleStyle();

	}

	/**
	 * getTags
	 *
	 * helper to get the tags from the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getTags() {

		return $this->getHead()->getTags();

	}

	/**
	 * getPublishedDate
	 *
	 * helper to get the published date from the proper place (header)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string
	 */
	public function getPublishedDate() {

		return $this->getHeader()->getPublishedDate();

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
	 * setArticleStyle
	 *
	 * helper to set the article style in the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $articleStyle
	 *
	 * @return  Article
	 */
	public function setArticleStyle($articleStyle) {

		$this->getHead()->setArticleStyle($articleStyle);

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

		if (empty($this->getTitle())) {
			throw new \Exception('title is required for all articles');
		} else {
			$this->_xmlElement->addChild('title', $this->getTitle());
		}

		if (empty($this->getLink())) {
			throw new \Exception('link is required for all articles');
		} else {
			$this->_xmlElement->addChild('link', $this->getLink());
		}

		if (!empty($this->getGuid())) {
			$this->_xmlElement->addChild('guid', $this->getGuid());
		}

		if (!empty($this->getDescription())) {
			$this->_xmlElement->addChild('description', $this->getDescription());
		}

		if (!empty($this->getPubDate())) {
			$this->_xmlElement->addChild(
				'pubDate',
				Base::formatRSSDate(
					$this->getPubDate()
				)
			);
		}

		if (!empty($this->getAuthors())) {
			foreach ($this->getAuthors() as $author) {
				$this->_xmlElement->addChild('author', $author);
			}
		}

		// attach article to document
		$this->_xmlElement->addCdataChild(
			'content:encoded',
			$this->getContentEncoded(),
			'http://purl.org/rss/1.0/modules/content/'
		);

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
		$this->__contentEncoded .= '<html lang="en" prefix="op: http://media.facebook.com/op#">';
		$this->__contentEncoded .= $this->getHead()->render();
		$this->__contentEncoded .= '<body>';
		$this->__contentEncoded .= '<' . $this->__docRoot . '>';

		// Header
		$this->__contentEncoded .= $this->getHeader()->render();

		// Article content / elements
		foreach ($this->__elements as $element) {
			$this->__contentEncoded .= $element->render();
		}

		// Footer
//		$this->__contentEncoded .= $this->getFooter()->render();

		$this->__contentEncoded .= '</' . $this->__docRoot . '>';
		$this->__contentEncoded .= '</body>';
		$this->__contentEncoded .= '</html>';

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
	 * @param   string  $title
	 * @param   boolean $alsoSetHeaderTitle
	 *
	 * @return  Article
	 */
	public function setTitle($title, $alsoSetHeaderTitle = true) {

		$this->_title = $title;

		if ($alsoSetHeaderTitle) {
			$this->getHeader()->setTitle($title);
		}

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
	 * @param string  $link
	 * @param boolean $alsoSetHeadLink
	 *
	 * @return Article
	 */
	public function setLink($link, $alsoSetHeadLink = true) {

		if ($alsoSetHeadLink) {
			$this->setCanonicalLink($link);
		} elseif ($this->isValidURL($link)) {
			$this->_link = $link;
		}

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
	 * @param boolean    $alsoSetHeaderPublishedDate
	 *
	 * @return Article
	 */
	public function setPubDate($pubDate, $alsoSetHeaderPublishedDate = true) {

		if ($alsoSetHeaderPublishedDate) {
			$this->setPublishedDate($pubDate);
		} else {
			$this->_pubDate = Base::formatRSSDate($pubDate);
		}

		return $this;

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
	 * setCanonicalLink
	 *
	 * helper to set the canonical link in the proper place (head)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string  $link
	 * @param boolean $alsoSetArticleLink
	 *
	 * @return Article
	 */
	public function setCanonicalLink($link, $alsoSetArticleLink = true) {

		$this->getHead()->setCanonicalLink($link);

		if ($alsoSetArticleLink) {
			$this->_link = $this->getHead()->getCanonicalLink();
		}

		return $this;

	}

	/**
	 * setPublishedDate
	 *
	 * helper to set the published date in the proper place (header)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string  $publishedDate
	 * @param boolean $alsoSetArticlePubDate
	 *
	 * @return  Article
	 */
	public function setPublishedDate($publishedDate, $alsoSetArticlePubDate = true) {

		$this->getHeader()->setPublishedDate($publishedDate);

		if ($alsoSetArticlePubDate) {
			$this->_pubDate = $this->getHeader()->getPublishedDate();
		}

		return $this;

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
	 * setModifiedDate
	 *
	 * helper to set the modified date in the proper place (header)
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $modifiedDate
	 *
	 * @return  Article
	 */
	public function setModifiedDate($modifiedDate) {

		$this->getHeader()->setModifiedDate($modifiedDate);

		return $this;

	}

}
