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

use Bit3\FlexiTree\Event\CollectItemsEvent;
use Bit3\FlexiTree\Matcher\Matcher;

/**
 * Class EventDrivenItemCollection
 */
class EventDrivenItemCollection
	extends ItemCollection
{
	/**
	 * @var EventDrivenItemFactory
	 */
	protected $factory;

	/**
	 * @var bool
	 */
	protected $loaded = false;

	/**
	 * @param ItemInterface          $parentItem
	 * @param EventDrivenItemFactory $factory
	 */
	function __construct(ItemInterface $parentItem, EventDrivenItemFactory $factory)
	{
		parent::__construct($parentItem);
		$this->factory = $factory;
	}

	protected function load()
	{
		if (!$this->loaded) {
			$this->loaded = true;

			$eventDispatcher = $this->factory->getEventDispatcher();
			$eventName       = $this->factory->getCollectItemsEventName();
			$event           = new CollectItemsEvent($this->factory, $this);
			$eventDispatcher->dispatch($eventName, $event);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function clear()
	{
		$this->loaded = true;
		return parent::clear();
	}

	/**
	 * {@inheritdoc}
	 */
	public function add(ItemInterface $item, ItemInterface $before = null)
	{
		$this->load();
		return parent::add($item, $before);
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove(ItemInterface $item)
	{
		$this->load();
		return parent::remove($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function contains(ItemInterface $item)
	{
		$this->load();
		return parent::contains($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function indexOf(ItemInterface $item)
	{
		$this->load();
		return parent::indexOf($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($index)
	{
		$this->load();
		return parent::get($index);
	}

	/**
	 * {@inheritdoc}
	 */
	public function previousSibling(ItemInterface $item)
	{
		$this->load();
		return parent::previousSibling($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function nextSibling(ItemInterface $item)
	{
		$this->load();
		return parent::nextSibling($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray()
	{
		$this->load();
		return parent::toArray();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator(Matcher $matcher = null)
	{
		$this->load();
		return parent::getIterator($matcher);
	}

	/**
	 * {@inheritdoc}
	 */
	public function count()
	{
		$this->load();
		return parent::count();
	}

	/**
	 * {@inheritdoc}
	 */
	public function isEmpty()
	{
		$this->load();
		return parent::isEmpty();
	}
}
