<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Condition;

use Bit3\FlexiTree\ItemInterface;

/**
 * Class ConditionInterface
 */
interface ConditionInterface
{
	/**
	 * Determine if the condition match on the item.
	 *
	 * @param ItemInterface $item
	 *
	 * @return bool
	 */
	public function matchItem(ItemInterface $item);

	/**
	 * Return a string that describe the condition in a human readable way.
	 *
	 * @return string
	 */
	public function describe();
}
