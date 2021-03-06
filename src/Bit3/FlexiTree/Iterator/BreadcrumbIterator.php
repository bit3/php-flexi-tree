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
 * Class BreadcrumbIterator
 */
class BreadcrumbIterator extends RecursiveItemIterator
{
	protected $actives = null;

	public function valid()
	{
		printf(
			"- valid\n   @ %s\n",
			$this->current() ? $this->current()
				->getName() : null
		);
		return parent::valid();
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasChildren()
	{
		printf(
			"- hasChildren\n   @ %s\n   <- %s\n",
			$this->current() ? $this->current()
				->getName() : null,
			$this->current()
				->hasChildren() ? 'true' : 'false'
		);
		return parent::hasChildren();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getChildren()
	{
		printf(
			"- getChildren\n   @ %s\n",
			$this->current() ? $this->current()
				->getName() : null
		);
		return parent::getChildren();
	}
}
