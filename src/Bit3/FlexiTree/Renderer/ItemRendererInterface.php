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

use Bit3\FlexiTree\ItemCollectionInterface;
use Bit3\FlexiTree\ItemInterface;

/**
 * Class ItemRendererInterface
 */
interface ItemRendererInterface
{
	public function renderItem(
		ItemInterface $item,
		ItemCollectionRendererInterface $collectionRenderer = null
	);
}