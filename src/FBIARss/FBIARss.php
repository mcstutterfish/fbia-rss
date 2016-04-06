<?php
namespace FBIARss;

use FBIARss\Element\ArticleItem;

/**
 * Class FBIARss
 *
 * @package     FBIARss
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class FBIARss {

	/**
	 * @var string
	 */
	protected $version = '';

	/**
	 * @var string
	 */
	protected $encoding = '';

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
	 * @param string $version
	 * @param string $encoding
	 *
	 * @return FBIARss
	 */
	public function feed($version, $encoding) {

		$this->version  = $version;
		$this->encoding = $encoding;

		return $this;

	}

	/**
	 * channel
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array $parameters     valid keys:
	 *                              - title (required)
	 *                              - link (required)
	 *                              - description (required)
	 *                              - language
	 *                              - lastBuildDate (autoadded if not passed)
	 *
	 * @return FBIARss
	 * @throws \Exception
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
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return ArticleItem
	 */
	public function createArticle() {

		return new ArticleItem();

	}

	/**
	 * completeArticle
	 *
	 * Add the article object created with createArticle after configuring all article elements
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param ArticleItem $articleItem
	 *
	 * @return FBIARss
	 */
	public function completeArticle(ArticleItem $articleItem) {

		$this->articles[] = $articleItem;

		return $this;

	}

	/**
	 * @param int $limit
	 *
	 * @return FBIARss
	 */
	public function limit($limit) {

		if (is_int($limit) and $limit > 0) {
			$this->limit = $limit;
		}

		return $this;

	}

	/**
	 * @param $filename
	 *
	 * @return mixed
	 */
	public function save($filename) {

		return $this->render()
			->asXML($filename);

	}

	/**
	 * @return SimpleXMLElement
	 */
	public function render() {

		$xml = new SimpleXMLElement(
			'<?xml version="1.0" encoding="' . $this->encoding . '"?><rss version="' . $this->version . '" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/"></rss>',
			LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL
		);

		$xml->addChild('channel');

		foreach ($this->channel as $kC => $vC) {
			$xml->channel->addChild($kC, $vC);
		}

		$articles = $this->limit > 0
			? array_slice($this->articles, 0, $this->limit)
			: $this->articles;

		foreach ($articles as $article) {
			$elem_item = $xml->channel->addChild('item');

			foreach ($article as $kI => $vI) {
				$options = explode('|', $kI);

				if (in_array('cdata', $options)) {
					$elem_item->addCdataChild($options[0], $vI);
				} elseif (strpos($options[0], ':') !== false) {
					$elem_item->addChild($options[0], $vI, 'http://purl.org/dc/elements/1.1/');
				} else {
					$elem_item->addChild($options[0], $vI);
				}
			}
		}

		return $xml;

	}

	/**
	 * @return mixed
	 */
	public function __toString() {

		return $this->render()
			->asXML();

	}

}
