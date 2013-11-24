<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree;

use Bit3\FlexiTree\Event\CreateItemEvent;
use Countable;
use Bit3\FlexiTree\Iterator\NavigationIterator;
use IteratorAggregate;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ItemFactoryInterface
 */
class EventDrivenItemFactory implements ItemFactoryInterface
{
	/**
	 * @var EventDispatcher
	 */
	protected $eventDispatcher;

	/**
	 * @var string
	 */
	protected $createItemEventName;

	/**
	 * @var string
	 */
	protected $collectItemsEventName;

	function __construct(
		EventDispatcher $eventDispatcher,
		$createItemEventName = 'flexi-tree.create-item',
		$collectItemsEventName = 'flexi-tree.collect-items'
	) {
		$this->eventDispatcher       = $eventDispatcher;
		$this->createItemEventName   = $createItemEventName;
		$this->collectItemsEventName = $collectItemsEventName;
	}

	/**
	 * @param EventDispatcher $eventDispatcher
	 */
	public function setEventDispatcher($eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;
		return $this;
	}

	/**
	 * @return EventDispatcher
	 */
	public function getEventDispatcher()
	{
		return $this->eventDispatcher;
	}

	/**
	 * @param string $eventName
	 */
	public function setCreateItemEventName($eventName)
	{
		$this->createItemEventName = $eventName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCreateItemEventName()
	{
		return $this->createItemEventName;
	}

	/**
	 * @param string $collectItemsEventName
	 */
	public function setCollectItemsEventName($collectItemsEventName)
	{
		$this->collectItemsEventName = $collectItemsEventName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCollectItemsEventName()
	{
		return $this->collectItemsEventName;
	}

	/**
	 * {@inheritdoc}
	 */
	public function createItem($type, $name, ItemInterface $parent = null)
	{
		$item = new EventDrivenItem($this);
		$item->setType($type);
		$item->setName($name);
		$item->setParent($parent);

		$event = new CreateItemEvent($item);
		$this->eventDispatcher->dispatch($this->createItemEventName, $event);

		return $item;
	}
}
