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

use Bit3\FlexiTree\Condition\ConditionInterface;
use Bit3\FlexiTree\ItemInterface;

/**
 * Class TypeCondition
 */
class TypeCondition implements ConditionInterface
{
	/**
	 * @var string
	 */
	protected $acceptedType;

	public function __construct($acceptedType = '?')
	{
		$this->acceptedType = (string) $acceptedType;
	}

	/**
	 * @param string $acceptedType
	 */
	public function setAcceptedType($acceptedType)
	{
		$this->acceptedType = (string) $acceptedType;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAcceptedType()
	{
		return $this->acceptedType;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		return $item->getType() == $this->acceptedType;
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		return 'item.type == ' . $this->acceptedType;
	}
}
