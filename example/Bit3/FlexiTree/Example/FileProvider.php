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
use Bit3\FlexiTree\Tree\ItemDataSource;
use Bit3\FlexiTree\Tree\ItemFactory;
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
class FileProvider implements ItemDataSource, ItemFactory
{
    /**
     * Collect a model list of all children for a parent item.
     *
     * @param Builder $builder
     * @param Item    $parent
     *
     * @return array
     */
    public function collectChildData(
        Builder $builder,
        Item $parent,
        $currentLevel
    ) {
        if ($parent->getData() instanceof SplFileInfo) {
            /** @var SplFileInfo $file */
            $file = $parent->getData();

            if ($file->isDir()) {
                $iterator = new FilesystemIterator($file->getPathname(), FilesystemIterator::CURRENT_AS_FILEINFO);

                $children = array();
                foreach ($iterator as $child) {
                    $children[] = $child;
                }
                return $children;
            }
        }

        return array();
    }

    /**
     * Generate an Item from the Model.
     *
     * @param Builder $builder
     * @param object  $model
     *
     * @return \Bit3\FlexiTree\Tree\Item
     */
    public function generateItem(
        Builder $builder,
        $model
    ) {
        if ($model instanceof SplFileInfo) {
            /** @var SplFileInfo $model */
            $item = new Item(
                $model->getBasename(),
                'file:' . $model->getPathname(),
                $model,
                'file'
            );
            return $item;
        }

        return false;
    }
}
