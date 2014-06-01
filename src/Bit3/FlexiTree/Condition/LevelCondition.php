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
 * Class LevelCondition
 */
class LevelCondition implements ConditionInterface
{
	protected $min = 0;

	protected $max = PHP_INT_MAX;

	public function __construct($max = 0, $min = 0)
	{
		$this->max = (int) $max;
		$this->min = (int) $min;
	}

	/**
	 * @param int $min
	 */
	public function setMin($min)
	{
		$this->min = (int) $min;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getMin()
	{
		return $this->min;
	}

	/**
	 * @param int $max
	 */
	public function setMax($max)
	{
		$this->max = (int) $max;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getMax()
	{
		return $this->max;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		$level = $item->getLevel();

		return $this->min <= $level && $level <= $this->max;
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		if ($this->min > 0 && $this->max != 0 && $this->max < PHP_INT_MAX) {
			return sprintf('%d <= item.level <= %d', $this->min, $this->max);
		}
		else if ($this->min > 0) {
			return sprintf('%d <= item.level', $this->min);
		}
		else if ($this->max < PHP_INT_MAX) {
			return sprintf('item.level <= %d', $this->max);
		}
		else {
			return 'true';
		}
	}
}
