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
 * Class TrailCondition
 */
class TrailCondition implements ConditionInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		return $item->isTrail();
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		return 'item.isTrail';
	}
}
