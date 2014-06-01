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

/**
 * Class ChainConditionInterface
 */
interface ChainConditionInterface extends ConditionInterface
{
	public function clearConditions();

	/**
	 * @param ConditionInterface $condition
	 */
	public function setConditions(array $conditions);

	public function addConditions(array $conditions);

	public function addCondition(ConditionInterface $condition);

	public function removeCondition(ConditionInterface $condition);

	public function containsCondition(ConditionInterface $condition);

	/**
	 * @return array|ConditionInterface[]
	 */
	public function getConditions();
}
