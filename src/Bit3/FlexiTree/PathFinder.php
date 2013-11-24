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

/**
 * Class PathFinder
 */
class PathFinder
{
	/**
	 * @var bool
	 */
	protected $multiPathEnabled = false;

	/**
	 * @param boolean $multiPath
	 */
	public function setMultiPathEnabled($multiPath)
	{
		$this->multiPathEnabled = $multiPath;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isMultiPathEnabled()
	{
		return $this->multiPathEnabled;
	}

	/**
	 * Find all items, matching the path.
	 *
	 * @param Matcher $matcher
	 * @param ItemInterface|ItemCollectionInterface $start
	 */
	public function find(Matcher $matcher, $start)
	{
		if ($start instanceof ItemInterface) {
			$paths = $this->findInItem($matcher, $start);
		}
		else if ($start instanceof ItemCollectionInterface) {
			$paths = $this->findInCollection($matcher, $start);
		}
		else {
			$paths = array();
		}

		if ($this->multiPathEnabled)  {
			return $paths;
		}
		else if (count($paths)) {
			return array_shift($paths);
		}

		return array();
	}

	/**
	 * @param ItemInterface $parent
	 * @param Matcher       $matcher
	 * @param ItemInterface $item
	 */
	protected function findInItem(Matcher $matcher, ItemInterface $item)
	{
		if ($matcher->matchItem($item)) {
			$paths = $this->findInCollection($matcher, $item->getChildren());

			if (count($paths)) {
				foreach ($paths as $index => $path) {
					array_unshift($paths[$index], $item);
				}
			}
			else {
				return array(array($item));
			}
		}

		return array();
	}

	/**
	 * @param ItemInterface           $parent
	 * @param Matcher                 $matcher
	 * @param ItemCollectionInterface $collection
	 */
	protected function findInCollection(Matcher $matcher, ItemCollectionInterface $collection)
	{
		$paths = array();

		/** @var ItemInterface $item */
		foreach ($collection as $item) {
			$path = $this->findInItem($matcher, $item);

			if (empty($path)) {
				continue;
			}

			$paths[] = $path;

			if (!$this->multiPathEnabled) {
				break;
			}
		}

		return $paths;
	}
}