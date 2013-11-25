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

use Bit3\FlexiTree\Matcher\Matcher;
use Countable;
use Bit3\FlexiTree\Iterator\NavigationIterator;
use IteratorAggregate;

/**
 * Class ItemCollectionInterface
 */
interface ItemCollectionInterface
	extends Countable, IteratorAggregate
{
	/**
	 * Return the item, this collection belongs to.
	 *
	 * @return ItemInterface
	 */
	public function getParentItem();

	/**
	 * Clear the collection.
	 *
	 * @return ItemCollectionInterface
	 */
	public function clear();

	/**
	 * Add an item.
	 *
	 * @param ItemInterface $item
	 *
	 * @return ItemCollectionInterface
	 */
	public function add(ItemInterface $item, ItemInterface $before = null);

	/**
	 * Add multiple items.
	 *
	 * @param ItemInterface[] $items
	 *
	 * @return ItemCollectionInterface
	 */
	public function addAll(array $items, ItemInterface $before = null);

	/**
	 * Remove an item.
	 *
	 * @param ItemInterface $item
	 *
	 * @return ItemCollectionInterface
	 */
	public function remove(ItemInterface $item);

	/**
	 * Remove multiple items.
	 *
	 * @param ItemInterface[] $items
	 *
	 * @return ItemCollectionInterface
	 */
	public function removeAll(array $items);

	/**
	 * Determine if an item exist in this collection.
	 *
	 * @param ItemInterface $item
	 *
	 * @return boolean
	 */
	public function contains(ItemInterface $item);

	/**
	 * Determine if multiple items exist in this collection.
	 *
	 * @param ItemInterface[] $items
	 *
	 * @return boolean
	 */
	public function containsAll(array $items);

	/**
	 * Return the index of an item.
	 *
	 * @param ItemInterface $item
	 *
	 * @return mixed
	 */
	public function indexOf(ItemInterface $item);

	/**
	 * Get an item at the position from this collection.
	 *
	 * @param int $index
	 *
	 * @return ItemInterface
	 */
	public function get($index);

	/**
	 * Get the previous sibling or null, if there is no item before.
	 *
	 * @param ItemInterface $item
	 *
	 * @return ItemInterface|null
	 */
	public function previousSibling(ItemInterface $item);

	/**
	 * Get the next sibling or null, if there is no item following.
	 *
	 * @param ItemInterface $item
	 *
	 * @return mixed
	 */
	public function nextSibling(ItemInterface $item);

	/**
	 * Determines if the collection is empty.
	 *
	 * @return boolean
	 */
	public function isEmpty();

	/**
	 * @return ItemInterface[]
	 */
	public function toArray();

	/**
	 * Duplicate the collection, optionally with all item children,
	 * otherwise the duplicated items has no children.
	 *
	 * @param boolean $deep Create a deep copy with all children.
	 *
	 * @return ItemCollectionInterface
	 */
	public function duplicate($deep = false);

	/**
	 * Makes a deep copy of collection. Every item is copied as another object.
	 * Doing "clone $collection" must be the same as "$collection->duplicate(true)"
	 */
	public function __clone();

	/**
	 * Retrieve an external iterator, if a matcher is given a FilterIterator is returned.
	 *
	 * @param Matcher $matcher
	 *
	 * @return \Traversable
	 */
	public function getIterator(Matcher $matcher = null);
}
