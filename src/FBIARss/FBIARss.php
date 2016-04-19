<?php
namespace FBIARss;

use FBIARss\Element\ArticleItem;
use FBIARss\Element\Base as BaseElement;

/**
 * Class FBIARss
 *
 * @package     FBIARss
 *
 * @since       0.1.1
 * @version     0.1.2
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 */
class FBIARss {

	/**
	 * @var string
	 */
	protected $version = '2.0';

	/**
	 * @var string
	 */
	protected $encoding = 'UTF-8';

	/**
	 * @var array
	 */
	protected $channel = [];

	/**
	 * @var null|\FBIARss\Element\Head
	 */
	protected $head = null;

	/**
	 * @var ArticleItem[]
	 */
	protected $articles = [];

	/**
	 * @var int
	 */
	protected $limit = 0;

	/**
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $version
	 * @param   string $encoding
	 *
	 * @return  \FBIARss
	 */
	public function feed($version = '2.0', $encoding = 'UTF-8') {

		$this->version  = $version;
		$this->encoding = $encoding;

		return $this;

	}

	/**
	 * channel
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   array $parameters           valid keys:
	 *                                      - title (required)
	 *                                      - link (required)
	 *                                      - description (required)
	 *                                      - language
	 *                                      - lastBuildDate (autoadded if not passed)
	 *
	 * @return  \FBIARss
	 * @throws  \Exception
	 */
	public function channel($parameters) {

		if (!array_key_exists('title', $parameters) || !array_key_exists('description', $parameters) || !array_key_exists(
				'link',
				$parameters
			)
		) {

			throw new \Exception('Required channel parameter missing : title, description or link');

		}

		if (array_key_exists('lastBuildDate', $parameters)) {
			if (!empty($parameters['lastBuildDate'])) {
				$parameters['lastBuildDate'] = BaseElement::formatRSSDate($parameters['lastBuildDate']);
			} else {
				$parameters['lastBuildDate'] = BaseElement::formatRSSDate();
			}
		} else {
			$parameters['lastBuildDate'] = BaseElement::formatRSSDate();
		}

		$this->channel = $parameters;

		return $this;

	}

	/**
	 * createArticle
	 *
	 * create an article object to be used when generating an article / Instant Article article elements
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  \FBIARss\Element\Article
	 */
	public function createArticle() {

		$ArticleItem = new ArticleItem();

		$this->articles[] = $ArticleItem;

		return $ArticleItem->getArticle();

	}

	/**
	 * attachArticle
	 *
	 * Add the article object created externally after configuring all article elements
	 *
	 * @since   0.1.1
	 * @version 0.1.2
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   ArticleItem $articleItem
	 *
	 * @return  \FBIARss
	 */
	public function attachArticle(ArticleItem $articleItem) {

		$this->articles[] = $articleItem;

		return $this;

	}

	/**
	 * limit
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   integer $limit
	 *
	 * @return  \FBIARss
	 */
	public function limit($limit) {

		if (is_int($limit) and $limit > 0) {
			$this->limit = $limit;
		}

		return $this;

	}

	/**
	 * save
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $filename
	 *
	 * @return  mixed
	 */
	public function save($filename) {

		return $this->render()->asXML($filename);

	}

	/**
	 * render
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return SimpleXMLElement
	 */
	public function render() {

		$xml = new SimpleXMLElement(
			'<?xml version="1.0" encoding="' . $this->encoding . '"?><rss version="' . $this->version . '" xmlns:content="http://purl.org/rss/1.0/modules/content/"></rss>',
			LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL
		);

		$channel = $xml->addChild('channel');

		foreach ($this->channel as $kC => $vC) {
			$channel->addChild($kC, $vC);
		}

		$articles = $this->limit > 0
			? array_slice($this->articles, 0, $this->limit)
			: $this->articles;

		foreach ($articles as $article) {
			$article->render($channel);
		}

		return $xml;

	}

	/**
	 * __toString
	 *
	 * @since   0.1.1
	 * @version 0.1.1
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return mixed
	 */
	public function __toString() {

		return $this->render()->asXML();

	}

}
