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

/**
 * Class ItemRenderer
 *
 *
 * @package ExtendedNavigation
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface ItemRenderer
{
    /**
     * Render an item into a single navigation link.
     *
     * @param Item $item
     * @param int  $index
     * @param bool $first
     * @param bool $last
     *
     * @return string
     */
    public function renderItem(Item $item, $index, $first, $last);
}