<?php
namespace FBIARss\Element;

use FBIARss\SimpleXMLElement;

/**
 * Class ArticleItem
 *
 * @package     FBIARss\Element
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class ArticleItem extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'item';

	/**
	 * @var null|Article
	 */
	protected $_article = null;

	/**
	 * ArticleItem constructor.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 */
	public function __construct() {

		$this->_article = new Article();

	}

	/**
	 * getArticle
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return Article
	 */
	public function getArticle() {

		return $this->_article;

	}

	/**
	 * render
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param SimpleXMLElement $xmlElement
	 *
	 * @return SimpleXMLElement
	 */
	public function render(SimpleXMLElement $xmlElement = null) {

		$this->_xmlElement = $xmlElement;

		$this->_xmlElement->addChild($this->getRoot());

		return $this->_article->render($this->_xmlElement);

	}

}
