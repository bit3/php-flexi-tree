<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Event;

use Bit3\FlexiTree\EventDrivenItemFactory;
use Bit3\FlexiTree\ItemCollectionInterface;
use Bit3\FlexiTree\ItemInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CollectItemsEvent
 */
class CollectItemsEvent extends Event
{
	/**
	 * @var EventDrivenItemFactory
	 */
	protected $factory;

	/**
	 * @var ItemCollectionInterface
	 */
	protected $collection;

	public function __construct(EventDrivenItemFactory $factory, ItemCollectionInterface $collection)
	{
		$this->factory    = $factory;
		$this->collection = $collection;
	}

	/**
	 * @return \Bit3\FlexiTree\EventDrivenItemFactory
	 */
	public function getFactory()
	{
		return $this->factory;
	}

	/**
	 * @return ItemInterface
	 */
	public function getParentItem()
	{
		return $this->collection->getParentItem();
	}

	/**
	 * @return ItemCollectionInterface
	 */
	public function getCollection()
	{
		return $this->collection;
	}
}
