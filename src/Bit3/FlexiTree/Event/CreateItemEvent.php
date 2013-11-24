<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Event;

use Bit3\FlexiTree\ItemInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CreateItemEvent
 */
class CreateItemEvent extends Event
{
	/**
	 * @var ItemInterface
	 */
	protected $item;

	function __construct(ItemInterface $item)
	{
		$this->item = $item;
	}

	/**
	 * @return ItemInterface
	 */
	public function getItem()
	{
		return $this->item;
	}
}
