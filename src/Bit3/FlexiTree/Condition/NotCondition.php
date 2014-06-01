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
 * Class NotCondition
 */
class NotCondition implements ConditionInterface
{
	/**
	 * @var ConditionInterface
	 */
	protected $condition;

	function __construct(ConditionInterface $condition)
	{
		$this->condition = $condition;
	}

	/**
	 * @param ConditionInterface $condition
	 */
	public function setCondition(ConditionInterface $condition)
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
		return !$this->condition->matchItem($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		return sprintf('not %s', $this->condition->describe());
	}
}
