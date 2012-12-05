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
use FrontendTemplate;

/**
 * Class UniversalTreeRenderer
 *
 *
 * @package ExtendedNavigation
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
class UniversalTreeRenderer implements ItemRenderer
{
    /**
     * Render an item into a single navigation link.
     *
     * @param Item $item
     *
     * @return string
     */
    public function renderItem(Item $item, $index, $first, $last)
    {
        $attributes = array();

        // add additional attributes
        foreach ($item->getAttributes() as $attr => $value) {
            $attributes[$attr] = trim(is_array($value) ? implode(' ', $value) : $value);
        }

        $classes = array($attributes['class']);
        // add trail/active class
        if ($item->getTrail()) {
            $classes[] = 'trail';
        }
        if ($item->getActive()) {
            $classes[] = 'active';
        }
        // add index/first/last class
        if ($first) {
            $classes[] = 'first';
        }
        if ($last) {
            $classes[] = 'last';
        }
        $classes[] = 'item_' . $index;
        // add type class
        $classes[] = 'type_' . str_replace('\\', '_', $item->getType());
        // update class attribute
        $attributes['class'] = trim(implode(' ', $classes));

        // add title attribute
        if (strlen($item->getTitle())) {
            $attributes['title'] = $item->getTitle();
        }

        // add href attribute
        $attributes['href'] = $item->getUrl();

        $template = new FrontendTemplate('xnav_item');

        $template->item       = $item;
        $template->attributes = $attributes;

        return $template->parse();
    }
}