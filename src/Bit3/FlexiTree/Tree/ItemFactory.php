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

/**
 * Class ItemFactory
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface ItemFactory
{
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
    );
}
