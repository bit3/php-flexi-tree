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

use Bit3\FlexiTree\Iterator\ItemFilterIterator;
use Bit3\FlexiTree\Matcher\Matcher;
use Countable;
use Bit3\FlexiTree\Iterator\NavigationIterator;
use IteratorAggregate;
use Traversable;

/**
 * Class ItemCollection
 */
class ItemCollection
	implements ItemCollectionInterface
{
	/**
	 * @var ItemInterface
	 */
	protected $parentItem;

	/**
	 * List of items.
	 *
	 * @var array
	 */
	protected $items = array();

	function __construct(ItemInterface $parentItem = null)
	{
		$this->parentItem = $parentItem;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParentItem()
	{
		return $this->parentItem;
	}

	/**
	 * {@inheritdoc}
	 */
	public function clear()
	{
		$this->items = array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function add(ItemInterface $item, ItemInterface $before = null)
	{
		$hash = spl_object_hash($item);
		if ($before) {
			$hashes = array_keys($this->items);
			$beforeHash = spl_object_hash($before);

			$indexOf = array_search($beforeHash, $hashes);

			if ($indexOf === false) {
				throw new \InvalidArgumentException('The before item is not part of this collection');
			}

			$existingIndex = array_search($hash, $hashes);

			if ($existingIndex === false || $existingIndex != ($indexOf-1)) {
				if ($existingIndex !== false) {
					unset($this->items[$hash]);

					if ($existingIndex < $indexOf) {
						$indexOf = array_search($beforeHash, $hashes);
					}
				}

				$this->items = array_merge(
					array_slice($this->items, 0, $indexOf),
					array($hash => $item),
					array_slice($this->items, $indexOf)
				);

				if ($existingIndex === false) {
					$item->setParentCollection($this);
				}
			}
		}
		else if (!isset($this->items[$hash])) {
			$this->items[$hash] = $item;
			$item->setParentCollection($this);
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addAll(array $items, ItemInterface $before = null)
	{
		foreach ($items as $item) {
			$this->add($item, $before);
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove(ItemInterface $item)
	{
		$hash = spl_object_hash($item);
		unset($this->items[$hash]);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeAll(array $items)
	{
		foreach ($items as $item) {
			$this->remove($item);
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function contains(ItemInterface $item)
	{
		$hash = spl_object_hash($item);
		return isset($this->items[$hash]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function containsAll(array $items)
	{
		foreach ($items as $item) {
			if (!$this->contains($item)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function indexOf(ItemInterface $item)
	{
		$hash   = spl_object_hash($item);
		$hashes = array_keys($this->items);
		return array_search($hash, $hashes);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($index)
	{
		$items = array_values($this->items);
		return isset($items[$index]) ? $items[$index] : null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function previousSibling(ItemInterface $item)
	{
		$hash    = spl_object_hash($item);
		$hashes  = array_keys($this->items);
		$indexOf = array_search($hash, $hashes);

		if ($indexOf === false) {
			throw new \InvalidArgumentException('The item is not part of this collection');
		}

		if ($indexOf > 0) {
			$hash = $hashes[$indexOf - 1];
			return $this->items[$hash];
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function nextSibling(ItemInterface $item)
	{
		$hash    = spl_object_hash($item);
		$hashes  = array_keys($this->items);
		$indexOf = array_search($hash, $hashes);

		if ($indexOf === false) {
			throw new \InvalidArgumentException('The item is not part of this collection');
		}

		if ($indexOf < count($hashes) - 1) {
			$hash = $hashes[$indexOf + 1];
			return $this->items[$hash];
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isEmpty()
	{
		return empty($this->items);
	}

	/**
	 * {@inheritdoc}
	 */
	public function count()
	{
		return count($this->items);
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray()
	{
		return array_values($this->items);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator(Matcher $matcher = null)
	{
		$iterator = new \ArrayIterator($this->items);

		if ($matcher) {
			$iterator = new ItemFilterIterator($iterator, $matcher);
		}

		return $iterator;
	}

	/**
	 * {@inheritdoc}
	 */
	public function duplicate($deep = false)
	{
		$collection = new static();

		foreach ($this->items as $item) {
			$collection->add($item->duplicate($deep));
		}

		return $collection;
	}

	/**
	 * {@inheritdoc}
	 */
	public function __clone()
	{
		$items = $this->items;
		$this->clear();
		foreach ($items as $item) {
			$this->add(clone $item);
		}
		$this->invalidateStructureCaches(false);
	}

	/**
	 * Clear structure related internal caches like trail and level status.
	 *
	 * @internal
	 */
	public function invalidateStructureCaches($deep = true)
	{
		foreach ($this->items as $item) {
			if ($item instanceof Item) {
				$item->invalidateStructureCaches($deep);
			}
		}
	}

	/**
	 * Clear structure related internal caches like trail and level status.
	 *
	 * @internal
	 */
	public function invalidateLevelCache($deep = true)
	{
		foreach ($this->items as $item) {
			if ($item instanceof Item) {
				$item->invalidateLevelCache($deep);
			}
		}
	}

	/**
	 * Clear structure related internal caches like trail and level status.
	 *
	 * @internal
	 */
	public function invalidateTrailStatusCache($deep = true)
	{
		foreach ($this->items as $item) {
			if ($item instanceof Item) {
				$item->invalidateTrailStatusCache($deep);
			}
		}
	}
}
