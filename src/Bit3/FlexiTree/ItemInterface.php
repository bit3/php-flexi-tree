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

use Bit3\FlexiTree\Condition\ConditionInterface;

/**
 * Class ItemInterface
 *
 * Inspired by the
 * {@link https://github.com/KnpLabs/KnpMenu/blob/master/src/Knp/Menu/ItemInterface.php
 * KnpMenu ItemInterface}.
 */
interface ItemInterface extends \Countable, \IteratorAggregate
{
	/**
	 * Set the item type.
	 *
	 * @param string $type
	 *
	 * @return ItemInterface
	 */
	public function setType($type);

	/**
	 * Return the item type.
	 *
	 * @return string
	 */
	public function getType();

	/**
	 * Set the item name.
	 *
	 * @param string $name
	 *
	 * @return ItemInterface
	 */
	public function setName($name);

	/**
	 * Return the item name.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Set the item uri.
	 *
	 * @param string $uri
	 *
	 * @return ItemInterface
	 */
	public function setUri($uri);

	/**
	 * Get the item uri.
	 *
	 * @return string
	 */
	public function getUri();

	/**
	 * Set the item label.
	 *
	 * @param string $label
	 *
	 * @return ItemInterface
	 */
	public function setLabel($label);

	/**
	 * Return the item label, return the name if no label is set.
	 *
	 * @return string
	 */
	public function getLabel();

	/**
	 * Set the item attributes.
	 *
	 * @param array $attributes
	 *
	 * @return ItemInterface
	 */
	public function setAttributes(array $attributes);

	/**
	 * Return the item attributes.
	 *
	 * @return array
	 */
	public function getAttributes();

	/**
	 * Set an item attribute.
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return ItemInterface
	 */
	public function setAttribute($name, $value);

	/**
	 * Return an item attribute.
	 *
	 * @param string $name    The name of the attribute to return
	 * @param mixed  $default The value to return if the attribute doesn't exist
	 *
	 * @return mixed
	 */
	public function getAttribute($name, $default = null);

	/**
	 * Set the link attributes.
	 *
	 * @param array $linkAttributes
	 *
	 * @return ItemInterface
	 */
	public function setLinkAttributes(array $linkAttributes);

	/**
	 * Return the link attributes.
	 *
	 * @return array
	 */
	public function getLinkAttributes();

	/**
	 * Set a link attribute.
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return ItemInterface
	 */
	public function setLinkAttribute($name, $value);

	/**
	 * Return a link attribute.
	 *
	 * @param string $name    The name of the attribute to return
	 * @param mixed  $default The value to return if the attribute doesn't exist
	 *
	 * @return mixed
	 */
	public function getLinkAttribute($name, $default = null);

	/**
	 * Set the label attributes.
	 *
	 * @param array $labelAttributes
	 *
	 * @return ItemInterface
	 */
	public function setLabelAttributes(array $labelAttributes);

	/**
	 * Get the label attributes.
	 *
	 * @return array
	 */
	public function getLabelAttributes();

	/**
	 * Set a label attribute.
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return ItemInterface
	 */
	public function setLabelAttribute($name, $value);

	/**
	 * Return a label attribute.
	 *
	 * @param string $name    The name of the attribute to return
	 * @param mixed  $default The value to return if the attribute doesn't exist
	 *
	 * @return mixed
	 */
	public function getLabelAttribute($name, $default = null);

	/**
	 * Set the item extra data.
	 *
	 * @param array $extras
	 *
	 * @return ItemInterface
	 */
	public function setExtras(array $extras);

	/**
	 * Return the item extra data.
	 *
	 * @return array
	 */
	public function getExtras();

	/**
	 * Set an item extra data value.
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return ItemInterface
	 */
	public function setExtra($name, $value);

	/**
	 * Return an item extra data value.
	 *
	 * @param string $name    The name of the attribute to return
	 * @param mixed  $default The value to return if the attribute doesn't exist
	 *
	 * @return mixed
	 */
	public function getExtra($name, $default = null);

	/**
	 * Set whether or not this menu item should show its children
	 *
	 * @param boolean $displayChildren
	 *
	 * @return ItemInterface
	 */
	public function setDisplayChildren($displayChildren);

	/**
	 * Whether or not this menu item should show its children.
	 *
	 * @return boolean
	 */
	public function isDisplayChildren();

	/**
	 * Set whether or not this menu should be displayed
	 *
	 * @param boolean $display
	 *
	 * @return ItemInterface
	 */
	public function setDisplay($display);

	/**
	 * Whether or not to display this menu item
	 *
	 * @return boolean
	 */
	public function isDisplayed();

	/**
	 * Sets whether or not this menu item is "current".
	 *
	 * If the state is unknown, use null.
	 *
	 * Provides a fluent interface
	 *
	 * @param boolean|null $current Specify that this menu item is current
	 *
	 * @return ItemInterface
	 */
	public function setCurrent($current);

	/**
	 * Gets whether or not this menu item is "current".
	 *
	 * @return boolean|null
	 */
	public function isCurrent();

	/**
	 * Enforce a trail status.
	 *
	 * @param boolean|null $trail If null is provided, the trail status will be detected by the child elements.
	 *
	 * @return ItemInterface
	 */
	public function setTrail($trail);

	/**
	 * Determine if the item is in the path to a current item.
	 *
	 * @return boolean
	 */
	public function isTrail();

	/**
	 * Returns the level of this menu item
	 *
	 * The root menu item is 0, followed by 1, 2, etc
	 *
	 * @return integer
	 */
	public function getLevel();

	/**
	 * Returns the root ItemInterface of this menu tree.
	 * May return itself, it this item is the root.
	 *
	 * @return ItemInterface
	 */
	public function getRoot();

	/**
	 * Returns whether or not this menu item is the root menu item
	 *
	 * @return boolean
	 */
	public function isRoot();

	/**
	 * Set the parent collection.
	 *
	 * @param ItemCollectionInterface|null $parent
	 *
	 * @return ItemInterface
	 */
	public function setParentCollection(ItemCollectionInterface $parentCollection = null);

	/**
	 * Return the parent collection.
	 *
	 * @return ItemCollectionInterface|null
	 */
	public function getParentCollection();

	/**
	 * Set the parent item.
	 *
	 * @param ItemInterface|null $parent
	 *
	 * @return ItemInterface
	 */
	public function setParent(ItemInterface $parent = null);

	/**
	 * Return the parent item.
	 *
	 * @return ItemInterface|null
	 */
	public function getParent();

	/**
	 * Returns whether or not this menu items has viewable children
	 *
	 * This menu MAY have children, but this will return false if the current
	 * user does not have access to view any of those items
	 *
	 * @return boolean
	 */
	public function hasChildren();

	/**
	 * @return ItemCollectionInterface
	 */
	public function getChildren();

	/**
	 * Duplicate the item, and filter all children.
	 * Return a duplicated item that only contains children, that match the condition.
	 * The condition will not be applied to the item, reduce is called on.
	 *
	 * @param boolean $deep Create a deep copy with all children
	 *
	 * @return ItemInterface
	 */
	public function reduce(ConditionInterface $condition);

	/**
	 * Duplicate the item, optionally with all children, otherwise the duplicate has no children.
	 *
	 * @param boolean $deep Create a deep copy with all children
	 *
	 * @return ItemInterface
	 */
	public function duplicate($deep = false);

	/**
	 * Makes a deep copy of menu tree. Every item is copied as another object.
	 * Doing "clone $item" must be the same as "$item->duplicate(true)"
	 */
	public function __clone();

	/**
	 * Retrieve an external iterator, if a condition is given a FilterIterator is returned.
	 *
	 * @param ConditionInterface $condition
	 *
	 * @return \Traversable
	 */
	public function getIterator(ConditionInterface $condition = null);
}
