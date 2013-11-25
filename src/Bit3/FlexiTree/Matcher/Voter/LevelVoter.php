<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Matcher\Voter;

use Bit3\FlexiTree\ItemInterface;

/**
 * Class LevelVoter
 */
class LevelVoter implements VoterInterface
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

		if ($this->min <= $level && $level <= $this->max) {
			return true;
		}

		return null;
	}
}
