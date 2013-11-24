<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree;

/**
 * Class ItemCollection
 */
class EventDrivenItem
	extends Item
{
	/**
	 * @param EventDrivenItemFactory $factory
	 */
	function __construct(EventDrivenItemFactory $factory)
	{
		$this->children = new EventDrivenItemCollection($this, $factory);
	}
}
