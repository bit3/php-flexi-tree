<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Tree;

use Bit3\FlexiTree\Builder;
use Bit3\FlexiTree\Tree\Item;
use Model;

/**
 * Class ItemDataSource
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface ItemDataSource
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
    );
}
