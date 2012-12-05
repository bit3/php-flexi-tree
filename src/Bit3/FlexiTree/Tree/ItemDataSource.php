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

namespace Bit3\FlexiTree\Tree;

use Bit3\FlexiTree\Generator;
use Bit3\FlexiTree\Tree\Item;
use Model;

/**
 * Class ItemDataSource
 *
 * @package ExtendedNavigation
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface ItemDataSource
{
    /**
     * Collect a model list of all children for a parent item.
     *
     * @param Generator $generator
     * @param Item      $parent
     *
     * @return array
     */
    public function collectChildData(
        Generator $generator,
        Item $parent,
        $currentLevel
    );
}
