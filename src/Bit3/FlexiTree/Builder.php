<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree;

use ArrayObject;
use Exception;
use Bit3\FlexiTree\Tree\Item;
use Bit3\FlexiTree\Tree\ItemFactory;
use Bit3\FlexiTree\Tree\ItemDataSource;

/**
 * Class Builder
 *
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
class Builder
{
    /**
     * List of item factories to use in this builder.
     *
     * @var ArrayObject
     */
    protected $itemFactories;

    /**
     * List of item data sources to use in this builder.
     *
     * @var ArrayObject
     */
    protected $itemDataSources;

    /**
     * Navigation tree root resource model.
     * In most cases this is a PageModel, but it can also be any other model.
     *
     * @var object
     */
    protected $root = null;

    /**
     * Include the root item when generate the tree.
     * If <em>true</em> <code>Builder::generate()</code> will return an <code>Item</code> (default).
     * Otherwise it will return an <code>ItemCollection</code>.
     *
     * @var bool
     */
    protected $includeRoot = false;

    /**
     * Include published items to the tree.
     *
     * @var bool
     */
    protected $includePublished = true;

    /**
     * Include unpublished items to the tree.
     *
     * @var bool
     */
    protected $includeUnpublished = false;

    /**
     * Include hidden items to the tree.
     *
     * @var bool
     */
    protected $includeHidden = false;

    /**
     * Include protected items to the tree, if the current user is allowed to see them.
     *
     * @var bool
     */
    protected $includeMembersOnly = true;

    /**
     * List of groups that are allowed to see protected items.
     *
     * @var array
     */
    protected $allowedGroups = array();

    /**
     * Include guests only items to the tree, if the current user is a guest.
     *
     * @var bool
     */
    protected $includeGuestsOnly = true;

    /**
     * The max tree height limit (can exceeded in trail).
     *
     * @var null|int
     */
    protected $maxLevel = null;

    /**
     * The hard tree height limit (cannot exceeded).
     *
     * @var null|int
     */
    protected $hardLevel = null;

    function __construct()
    {
        $this->itemFactories = new ArrayObject();
        $this->itemDataSources = new ArrayObject();
    }

    /**
     * @param array $factories
     */
    public function setItemFactories(array $factories)
    {
        $this->itemFactories = new ArrayObject();

        foreach ($factories as $provider) {
            $this->addItemFactory($provider);
        }
    }

    /**
     * @param ItemFactory $factory
     */
    public function addItemFactory(ItemFactory $factory)
    {
        $this->itemFactories->append($factory);
    }

    /**
     * @return array
     */
    public function getItemFactories()
    {
        return $this->itemFactories;
    }

    /**
     * @param \ArrayObject $itemDataSources
     */
    public function setItemDataSources($itemDataSources)
    {
        $this->itemDataSources = new ArrayObject();

        foreach ($itemDataSources as $itemDataSource) {
            $this->addItemDataSource($itemDataSource);
        }
    }

    /**
     * @param ItemDataSource $itemDataSource
     */
    public function addItemDataSource(ItemDataSource $itemDataSource)
    {
        $this->itemDataSources->append($itemDataSource);
    }

    /**
     * @return \ArrayObject
     */
    public function getItemDataSources()
    {
        return $this->itemDataSources;
    }

    /**
     * @param object $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * @return \Model
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param boolean $includeRoot
     */
    public function setIncludeRoot($includeRoot)
    {
        $this->includeRoot = (bool) $includeRoot;
    }

    /**
     * @return boolean
     */
    public function getIncludeRoot()
    {
        return $this->includeRoot;
    }

    /**
     * @param boolean $includePublished
     */
    public function setIncludePublished($includePublished)
    {
        $this->includePublished = (bool) $includePublished;
    }

    /**
     * @return boolean
     */
    public function getIncludePublished()
    {
        return $this->includePublished;
    }

    /**
     * @param boolean $includeUnpublished
     */
    public function setIncludeUnpublished($includeUnpublished)
    {
        $this->includeUnpublished = (bool) $includeUnpublished;
    }

    /**
     * @return boolean
     */
    public function getIncludeUnpublished()
    {
        return $this->includeUnpublished;
    }

    /**
     * @param boolean $includeHidden
     */
    public function setIncludeHidden($includeHidden)
    {
        $this->includeHidden = (bool) $includeHidden;
    }

    /**
     * @return boolean
     */
    public function getIncludeHidden()
    {
        return $this->includeHidden;
    }

    /**
     * @param boolean $includeProtected
     */
    public function setIncludeMembersOnly($includeProtected)
    {
        $this->includeMembersOnly = (bool) $includeProtected;
    }

    /**
     * @return boolean
     */
    public function getIncludeMembersOnly()
    {
        return $this->includeMembersOnly;
    }

    /**
     * @param array $protectedGroups
     */
    public function setAllowedGroups(array $protectedGroups)
    {
        foreach ($protectedGroups as $k => $v) {
            if (is_object($v)) {
                $protectedGroups[$k] = $v->id;
            }
            else if (is_array($v)) {
                $protectedGroups[$k] = $v['id'];
            }
        }

        $this->allowedGroups = $protectedGroups;
    }

    /**
     * @return array
     */
    public function getAllowedGroups()
    {
        return $this->allowedGroups;
    }

    /**
     * @param boolean $includeGuestsOnly
     */
    public function setIncludeGuestsOnly($includeGuestsOnly)
    {
        $this->includeGuestsOnly = $includeGuestsOnly;
    }

    /**
     * @return boolean
     */
    public function getIncludeGuestsOnly()
    {
        return $this->includeGuestsOnly;
    }

    /**
     * @param int|null $maxLevel
     */
    public function setMaxLevel($maxLevel)
    {
        $this->maxLevel = is_null($maxLevel) ? null : (int) $maxLevel;
    }

    /**
     * @return int|null
     */
    public function getMaxLevel()
    {
        return $this->maxLevel;
    }

    /**
     * @param int|null $hardLevel
     */
    public function setHardLevel($hardLevel)
    {
        $this->hardLevel = is_null($hardLevel) ? null : (int) $hardLevel;
    }

    /**
     * @return int|null
     */
    public function getHardLevel()
    {
        return $this->hardLevel;
    }

    /**
     * Check if a given level is allowed to display.
     *
     * @param int  $currentLevel
     * @param bool $inTrail
     *
     * @return bool
     */
    public function isLevelAllowed($currentLevel, $inTrail = false)
    {
        if ($this->hardLevel > 0) {
            return $currentLevel <= $this->hardLevel;
        }
        if ($this->maxLevel > 0 && !$inTrail) {
            return $currentLevel <= $this->maxLevel;
        }
        return true;
    }

    /**
     * Generate a tree of items.
     *
     * return Item|ItemCollection
     */
    public function generate()
    {
        if ($this->root === null) {
            throw new Exception('Tree root model is missing, use Builder::setRoot() to define a tree root model.');
        }

        $root = $this->generateItem($this->root);

        $this->generateLevel($root);

        if ($this->includeRoot) {
            return $root;
        }
        else {
            return $root->getChildren();
        }
    }

    /**
     * @param Item $parent
     * @param int  $currentLevel
     */
    protected function generateLevel(Item $parent, $currentLevel = 1)
    {
        /** @var ItemDataSource $dataSource */
        foreach ($this->itemDataSources as $dataSource) {
            // fetch all models for this parent
            $children = $dataSource->collectChildData($this, $parent, $currentLevel);

            foreach ($children as $data) {
                // generate an item for the current model
                $item = $this->generateItem($data);

                // add current item to the parent
                $parent->addChildren($item);
            }
        }

        // walk of all items in this level and generate the next one
        foreach ($parent->getChildren() as $item) {
            $this->generateLevel($item, $currentLevel + 1);
        }
    }

    /**
     * @param object $model
     *
     * @return Item
     * @throws \Exception
     */
    protected function generateItem($model)
    {
        /** @var Provider $provider */
        foreach ($this->itemFactories as $provider) {
            $item = $provider->generateItem($this, $model);

            if ($item) {
                return $item;
            }
        }

        throw new Exception(
            sprintf(
                'Could not generate item from model %s, no provider can handle it.',
                get_class($model)
            )
        );
    }
}
