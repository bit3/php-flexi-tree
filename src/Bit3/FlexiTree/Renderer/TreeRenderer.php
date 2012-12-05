<?php

/**
 * ExtendedNavigation
 * extension for Contao Open Source CMS
 *
 * @package ExtendedNavigation
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Renderer;

use Bit3\FlexiTree\Tree\Item;
use Bit3\FlexiTree\Tree\ItemCollection;

/**
 * Class TreeRenderer
 *
 *
 * @package ExtendedNavigation
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface TreeRenderer
{
    /**
     * Render a tree into a complete navigation.
     *
     * @param Item|ItemCollection $tree
     * @param ItemRenderer
     *
     * @return string
     */
    public function renderTree($tree, ItemRenderer $itemRenderer);
}