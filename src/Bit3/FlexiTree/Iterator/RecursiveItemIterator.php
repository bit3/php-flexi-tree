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

use RecursiveIterator;

/**
 * Class DefaultPageProvider
 */
class RecursiveItemIterator extends \IteratorIterator implements RecursiveIterator
{
	/**
	 * {@inheritdoc}
	 */
	public function hasChildren()
	{
		return $this->current()
			->hasChildren();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getChildren()
	{
		return new static($this->current()
			->getIterator());
	}

}
