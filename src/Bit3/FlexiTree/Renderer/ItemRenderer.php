<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Renderer;

use Bit3\FlexiTree\Tree\Item;

/**
 * Class ItemRenderer
 *
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface ItemRenderer
{
    /**
     * Render an item into a single navigation link.
     *
     * @param Item   $item
     * @param int    $depth
     * @param int    $index
     * @param bool   $first
     * @param bool   $last
     * @param string $renderedChildren
     *
     * @return string
     */
    public function renderItem(Item $item, $depth, $index, $first, $last, $renderedChildren);
}