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
 * Class AbstractConjunctionCondition
 */
abstract class AbstractConjunctionCondition implements ConditionInterface, ChainConditionInterface
{
	/**
	 * @var ConditionInterface[]
	 */
	protected $conditions = array();

	/**
	 * @param array|ConditionInterface[] $conditions
	 */
	function __construct(array $conditions = array())
	{
		$this->addConditions($conditions);
	}

	public function clearConditions()
	{
		$this->conditions = array();
	}

	/**
	 * @param ConditionInterface $condition
	 */
	public function setConditions(array $conditions)
	{
		$this->clearConditions();
		$this->addConditions($conditions);
		return $this;
	}

	public function addConditions(array $conditions)
	{
		foreach ($conditions as $condition) {
			$this->addCondition($condition);
		}
	}

	public function addCondition(ConditionInterface $condition)
	{
		$hash = spl_object_hash($condition);
		unset($this->conditions[$hash]);
		$this->conditions[$hash] = $condition;
	}

	public function removeCondition(ConditionInterface $condition)
	{
		$hash = spl_object_hash($condition);
		unset($this->conditions[$hash]);
	}

	public function containsCondition(ConditionInterface $condition)
	{
		$hash = spl_object_hash($condition);
		return isset($this->conditions[$hash]);
	}

	/**
	 * @return array|ConditionInterface[]
	 */
	public function getConditions()
	{
		return $this->conditions;
	}
}
