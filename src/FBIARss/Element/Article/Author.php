<?php
namespace FBIARss\Element\Article;

use FBIARss\Element\Article;
use FBIARss\Element\Base;
use FBIARss\SimpleXMLElement;

/**
 * Class Author
 *
 * @package     FBIARss\Element
 * @subpackage  FBIARss\Element\Article
 *
 * @author      Christopher M. Black <cblack@devonium.com>
 *
 * @version     0.1.1
 * @since       0.1.1
 */
class Author extends Base {

	/**
	 * @var string
	 */
	protected $_root = 'address';

	/**
	 * The name of the author. (required)
	 *
	 * @var string
	 */
	protected $_name = '';

	/**
	 * The title or role of the author.
	 *
	 * @var string
	 */
	protected $_role = '';

	/**
	 * The author's contribution to this article.
	 *
	 * @var string
	 */
	protected $_contribution = '';

	/**
	 * A short bio about the author.
	 *
	 * @var string
	 */
	protected $_bio = '';

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
		if (empty($this->getName())) {
			throw new \Exception('name is required for all authors');
		}

		// Setup author title if available
		$authorTitle = '';
		if (!empty($this->getRole())) {
			$authorTitle .= $this->getRole();
		}

		if (!empty($this->getContribution())) {
			$authorTitle .= ' (' . $this->getContribution() . ')';
		}

		$authorString = '        <' . $this->getRoot() . '>';

		// Add subtitle
		if (!empty($authorTitle)) {
			$authorString .= '        <a title="' . $authorTitle . '">' . $this->getName() . '</a>';
		} else {
			$authorString .= '        <a>' . $this->getName() . '</a>';
		}

		// add kicker
		if (!empty($this->getBio())) {
			$authorString .= '        ' . $this->getBio();
		}

		$authorString .= '        </' . $this->getRoot() . '>';

		return $authorString;

	}

	/**
	 * getName
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_name
	 */
	public function getName() {

		return $this->_name;

	}

	/**
	 * setName
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $name
	 *
	 * @return  Author
	 */
	public function setName($name) {

		$this->_name = $name;

		return $this;

	}

	/**
	 * getRole
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_role
	 */
	public function getRole() {

		return $this->_role;

	}

	/**
	 * setRole
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $role
	 *
	 * @return  Author
	 */
	public function setRole($role) {

		$this->_role = $role;

		return $this;

	}

	/**
	 * getContribution
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_contribution
	 */
	public function getContribution() {

		return $this->_contribution;

	}

	/**
	 * setContribution
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $contribution
	 *
	 * @return  Author
	 */
	public function setContribution($contribution) {

		$this->_contribution = $contribution;

		return $this;

	}

	/**
	 * getBio
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return  string    $_bio
	 */
	public function getBio() {

		return $this->_bio;

	}

	/**
	 * setBio
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param   string $bio
	 *
	 * @return  Author
	 */
	public function setBio($bio) {

		$this->_bio = $bio;

		return $this;

	}

}
