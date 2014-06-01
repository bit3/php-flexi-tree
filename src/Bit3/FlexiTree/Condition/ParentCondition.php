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
 * Class ParentCondition
 */
class ParentCondition implements ConditionInterface
{
	/**
	 * @var ConditionInterface|null
	 */
	protected $condition;

	function __construct(ConditionInterface $condition = null)
	{
		$this->condition = $condition;
	}

	/**
	 * @param ConditionInterface $condition
	 */
	public function setCondition(ConditionInterface $condition = null)
	{
		$this->condition = $condition;
		return $this;
	}

	/**
	 * @return ConditionInterface
	 */
	public function getCondition()
	{
		return $this->condition;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		$parent = $item->getParent();

		if (!$parent) {
			return false;
		}
		if ($this->condition) {
			return $this->condition->matchItem($parent);
		}

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		return $this->condition ? 'item.parent(' . $this->condition->describe() . ')' : 'item.parent != null';
	}
}
