<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Example;

use Bit3\FlexiTree\Builder;
use Bit3\FlexiTree\Tree\Item;
use Bit3\FlexiTree\Tree\ItemCollection;
use Bit3\FlexiTree\Renderer\ItemRenderer;
use Bit3\FlexiTree\Renderer\ItemListRenderer;
use FilesystemIterator;
use SplFileInfo;

/**
 * Class ItemFactory
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
class FileRenderer implements ItemRenderer, ItemListRenderer
{
    /**
     * Render an item into a single navigation link.
     *
     * @param Item $item
     * @param int  $depth
     * @param int  $index
     * @param bool $first
     * @param bool $last
     *
     * @return string
     */
    public function renderItems(array $renderedItems, $depth)
    {
        $buffer = '';
        foreach ($renderedItems as $item) {
            $buffer .= $item;
        }
        return $buffer;
    }

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
    public function renderItem(Item $item, $depth, $index, $first, $last, $renderedChildren)
    {
        $buffer = '';
        for ($i=1; $i<$depth; $i++) {
            $buffer .= '  ';
        }
        $buffer .= '- ';

        $buffer .= $item->getLabel() . "\n";

        $buffer .= $renderedChildren;

        return $buffer;
    }
}
