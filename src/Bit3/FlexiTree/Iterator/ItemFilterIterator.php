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

use Bit3\FlexiTree\Condition\ConditionInterface;
use RecursiveIterator;

/**
 * Class ItemFilterIterator
 */
class ItemFilterIterator extends \FilterIterator
{
	/**
	 * @var ConditionInterface
	 */
	protected $condition;

	public function __construct(\Iterator $iterator, ConditionInterface $condition)
	{
		parent::__construct($iterator);
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
	public function accept()
	{
		return $this->condition->matchItem($this->current());
	}
}
