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
use Traversable;

/**
 * Class ItemInterface
 */
class Item implements ItemInterface
{
	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * @var array
	 */
	protected $linkAttributes = array();

	/**
	 * @var array
	 */
	protected $labelAttributes = array();

	/**
	 * @var array
	 */
	protected $extras = array();

	/**
	 * @var bool
	 */
	protected $displayChildren = true;

	/**
	 * @var bool
	 */
	protected $display = true;

	/**
	 * @var bool
	 */
	protected $current = false;

	/**
	 * @var ItemCollectionInterface|null
	 */
	protected $parentCollection = null;

	/**
	 * @var ItemCollectionInterface|ItemInterface[]
	 */
	protected $children;

	/**
	 * Cached level
	 *
	 * @internal
	 * @var boolean|null
	 */
	protected $cachedLevel = null;

	/**
	 * Cached trail status.
	 *
	 * @internal
	 * @var boolean|null
	 */
	protected $cachedTrailStatus = null;

	function __construct()
	{
		$this->children = new ItemCollection($this);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setType($type)
	{
		$this->type = (string) $type;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setName($name)
	{
		$this->name = (string) $name;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setUri($uri)
	{
		$this->uri = (string) $uri;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLabel($label)
	{
		$this->label = (string) $label;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLabel()
	{
		return $this->label ?: $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAttributes(array $attributes)
	{
		$this->attributes = $attributes;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAttribute($name, $value)
	{
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttribute($name, $default = null)
	{
		return isset($this->attributes[$name])
			? $this->attributes[$name]
			: $default;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLinkAttributes(array $linkAttributes)
	{
		$this->linkAttributes = $linkAttributes;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLinkAttributes()
	{
		return $this->linkAttributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLinkAttribute($name, $value)
	{
		$this->linkAttributes[$name] = $value;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLinkAttribute($name, $default = null)
	{
		return isset($this->linkAttributes[$name])
			? $this->linkAttributes[$name]
			: $default;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLabelAttributes(array $labelAttributes)
	{
		$this->labelAttributes = $labelAttributes;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLabelAttributes()
	{
		return $this->labelAttributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLabelAttribute($name, $value)
	{
		$this->labelAttributes[$name] = $value;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLabelAttribute($name, $default = null)
	{
		return isset($this->labelAttributes[$name])
			? $this->labelAttributes[$name]
			: $default;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setExtras(array $extras)
	{
		$this->extras = $extras;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtras()
	{
		return $this->extras;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setExtra($name, $value)
	{
		$this->extras[$name] = $value;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtra($name, $default = null)
	{
		return isset($this->extras[$name])
			? $this->extras[$name]
			: $default;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDisplayChildren($displayChildren)
	{
		$this->displayChildren = (bool) $displayChildren;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isDisplayChildren()
	{
		return $this->displayChildren;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDisplay($display)
	{
		$this->display = (bool) $display;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isDisplayed()
	{
		return $this->display;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCurrent($current)
	{
		$current = (bool) $current;

		if ($this->current == $current) {
			return;
		}

		$this->current = $current;

		$item = $this;
		do {
			$item->invalidateTrailStatusCache(false);
			$item = $item->getParent();
		} while ($item);
	}

	/**
	 * {@inheritdoc}
	 */
	public function isCurrent()
	{
		return $this->current;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isTrail()
	{
		if ($this->cachedTrailStatus === null) {
			$this->cachedTrailStatus = false;
			foreach ($this->children as $child) {
				$trailStatus = $child->isCurrent() || $child->isTrail();

				if ($trailStatus) {
					$this->cachedTrailStatus = true;
					break;
				}
			}
		}

		return $this->cachedTrailStatus;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLevel()
	{
		if ($this->cachedLevel === null) {
			$this->cachedLevel = $this->isRoot()
				? 0
				: $this->getParent()
					->getLevel() + 1;
		}

		return $this->cachedLevel;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRoot()
	{
		return $this->isRoot()
			? $this
			: $this->getParent()->getRoot();
	}

	/**
	 * {@inheritdoc}
	 */
	public function isRoot()
	{
		return !$this->parentCollection || !$this->parentCollection->getParentItem();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setParentCollection(ItemCollectionInterface $parentCollection = null)
	{
		if ($this->parentCollection == $parentCollection) {
			return;
		}

		$this->invalidateStructureCaches();

		if ($this->parentCollection) {
			$this->parentCollection->remove($this);
		}
		$this->parentCollection = $parentCollection;
		if ($this->parentCollection) {
			$this->parentCollection->add($this);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParentCollection()
	{
		return $this->parentCollection;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setParent(ItemInterface $parent = null)
	{
		$this->setParentCollection($parent ? $parent->getChildren() : null);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParent()
	{
		return $this->parentCollection
			? $this->parentCollection->getParentItem()
			: null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasChildren()
	{
		return !$this->getChildren()
			->isEmpty();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getChildren()
	{
		return $this->children;
	}

	/**
	 * {@inheritdoc}
	 */
	public function duplicate($deep = false)
	{
		/** @var Item $item */
		$item = new static();
		$item->type = $this->type;
		$item->name = $this->name;
		$item->uri = $this->uri;
		$item->label = $this->label;
		$item->attributes = $this->attributes;
		$item->linkAttributes = $this->linkAttributes;
		$item->labelAttributes = $this->labelAttributes;
		$item->extras = $this->extras;
		$item->displayChildren = $this->displayChildren;
		$item->display = $this->display;
		$item->current = $this->current;

		if ($deep) {
			$children = $item->getChildren();
			foreach ($this->children as $child) {
				$children->add($child->duplicate($deep));
			}
		}

		return $children;
	}

	/**
	 * {@inheritdoc}
	 */
	public function __clone()
	{
		if ($this->children) {
			$this->children = clone $this->children;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function count()
	{
		return $this->getChildren()->count();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator(Matcher $matcher = null)
	{
		return $this->getChildren()->getIterator($matcher);
	}

	/**
	 * Clear structure related internal caches like trail and level status.
	 *
	 * @internal
	 */
	public function invalidateStructureCaches($deep = true)
	{
		$this->cachedLevel = null;
		$this->cachedTrailStatus = null;

		if ($deep && $this->children instanceof ItemCollection) {
			$this->children->invalidateStructureCaches();
		}
	}

	/**
	 * Clear structure related internal caches like trail and level status.
	 *
	 * @internal
	 */
	public function invalidateLevelCache($deep = true)
	{
		$this->cachedLevel = null;

		if ($deep && $this->children instanceof ItemCollection) {
			$this->children->invalidateLevelCache();
		}
	}

	/**
	 * Clear structure related internal caches like trail and level status.
	 *
	 * @internal
	 */
	public function invalidateTrailStatusCache($deep = true)
	{
		$this->cachedTrailStatus = null;

		if ($deep && $this->children instanceof ItemCollection) {
			$this->children->invalidateTrailStatusCache();
		}
	}
}
