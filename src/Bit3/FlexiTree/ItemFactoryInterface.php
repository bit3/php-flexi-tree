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

use Countable;
use Bit3\FlexiTree\Iterator\NavigationIterator;
use IteratorAggregate;

/**
 * Class ItemFactoryInterface
 */
interface ItemFactoryInterface
{
	/**
	 * @param string        $type
	 * @param mixed         $identifier
	 * @param ItemInterface $parent
	 *
	 * @return ItemInterface
	 */
	public function createItem($type, $identifier, ItemInterface $parent = null);
}
