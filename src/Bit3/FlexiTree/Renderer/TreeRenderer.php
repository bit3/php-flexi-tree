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
use Bit3\FlexiTree\Tree\ItemCollection;
use Bit3\FlexiTree\Renderer\ItemRenderer;
use Bit3\FlexiTree\Renderer\ItemListRenderer;
use Exception;

/**
 * Class TreeRenderer
 *
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
class TreeRenderer
{
    /**
     * @var ItemCollectionRenderer
     */
    protected $itemListRenderer = null;

    /**
     * List of item renderers.
     *
     * @var array
     */
    protected $itemRenderers = array();

    /**
     * @param \Bit3\FlexiTree\Renderer\ItemCollectionRenderer $itemListRenderer
     */
    public function setItemListRenderer($itemListRenderer)
    {
        $this->itemListRenderer = $itemListRenderer;
    }

    /**
     * @return \Bit3\FlexiTree\Renderer\ItemCollectionRenderer
     */
    public function getItemListRenderer()
    {
        return $this->itemListRenderer;
    }

    /**
     * @param array $itemRenderers
     */
    public function setItemRenderers($itemRenderers)
    {
        $this->itemRenderers = $itemRenderers;
    }

    /**
     * @return array
     */
    public function getItemRenderers()
    {
        return $this->itemRenderers;
    }

    /**
     * @param ItemRenderer $itemRenderer
     */
    public function addItemRenderer(ItemRenderer $itemRenderer)
    {
        $this->itemRenderers[] = $itemRenderer;
    }

    /**
     * Render a tree into a complete navigation.
     *
     * @param Item|ItemCollection $tree
     *
     * @return string
     */
    public function renderTree($tree)
    {
        if ($tree instanceof Item) {
            return $this->renderItem(
                $tree,
                1,
                1,
                true,
                true
            );
        }
        else if ($tree instanceof ItemCollection) {
            return $this->renderCollection($tree, 1);
        }

        throw new Exception(
            sprintf(
                'Could not render %s',
                get_class($tree)
            )
        );
    }

    public function renderItem(Item $item, $depth, $index, $first, $last)
    {
        /** @var ItemRenderer $itemRenderer */
        foreach ($this->itemRenderers as $itemRenderer) {
            $renderedChildren = $this->renderCollection(
                $item->getChildren(),
                $depth+1
            );

            $buffer = $itemRenderer->renderItem(
                $item,
                $depth,
                $index,
                $first,
                $last,
                $renderedChildren
            );

            if (is_string($buffer)) {
                return $buffer;
            }
        }

        throw new Exception(
            sprintf(
                'Could not render item of type %s.',
                $item->getType()
            )
        );
    }

    public function renderCollection(ItemCollection $collection, $depth)
    {
        $rendered = array();
        $index = 1;
        $max = $collection->count();
        foreach ($collection as $item) {
            $rendered[] = $this->renderItem(
                $item,
                $depth,
                $index,
                $index == 1,
                $index == $max
            );
        }

        return $this->itemListRenderer->renderItems($rendered, $depth);
    }
}