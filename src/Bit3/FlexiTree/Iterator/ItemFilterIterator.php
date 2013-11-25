<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Iterator;

use Bit3\FlexiTree\Matcher\Matcher;
use RecursiveIterator;

/**
 * Class ItemFilterIterator
 */
class ItemFilterIterator extends \FilterIterator
{
	/**
	 * @var Matcher
	 */
	protected $matcher;

	public function __construct(\Iterator $iterator, Matcher $matcher)
	{
		parent::__construct($iterator);
		$this->matcher = $matcher;
	}

	/**
	 * @param Matcher $matcher
	 */
	public function setMatcher(Matcher $matcher)
	{
		$this->matcher = $matcher;
		return $this;
	}

	/**
	 * @return Matcher
	 */
	public function getMatcher()
	{
		return $this->matcher;
	}

	/**
	 * {@inheritdoc}
	 */
	public function accept()
	{
		return $this->matcher->matchItem($this->current());
	}
}
