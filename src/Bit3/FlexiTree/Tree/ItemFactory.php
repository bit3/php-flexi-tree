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

/**
 * Class ItemFactory
 *
 * @package ExtendedNavigation
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
interface ItemFactory
{
    /**
     * Generate an Item from the Model.
     *
     * @param Generator $generator
     * @param object    $model
     *
     * @return \Bit3\FlexiTree\Tree\Item
     */
    public function generateItem(
        Generator $generator,
        $model
    );
}
