<?php

/**
 * FlexiTree
 *
 * @package FlexiTree
 * @author  Tristan Lins <tristan.lins@bit3.de>
 * @link    http://bit3.de
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\FlexiTree\Matcher;

use Bit3\FlexiTree\ItemInterface;
use Bit3\FlexiTree\Matcher\Voter\VoterInterface;

/**
 * Class Matcher
 */
class Matcher
{
	/**
	 * @var bool
	 */
	protected $defaultMatch = false;

	/**
	 * @var VoterInterface[]
	 */
	protected $voter = array();

	public function __construct($defaultMatch = false)
	{
		$this->defaultMatch = (bool) $defaultMatch;
	}

	/**
	 * @param boolean $defaultMatch
	 */
	public function setDefaultMatch($defaultMatch)
	{
		$this->defaultMatch = (bool) $defaultMatch;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isDefaultMatch()
	{
		return $this->defaultMatch;
	}

	public function clearVoter()
	{
		$this->voter = array();
	}

	public function addVoter(VoterInterface $voter)
	{
		$hash               = spl_object_hash($voter);
		$this->voter[$hash] = $voter;
	}

	public function removeVoter(VoterInterface $voter)
	{
		$hash = spl_object_hash($voter);
		unset($this->voter[$hash]);
	}

	public function hasVoter()
	{
		return (bool) count($this->voter);
	}

	public function getVoter()
	{
		return array_values($this->voter);
	}

	/**
	 * @param ItemInterface $item
	 *
	 * @return bool
	 */
	public function matchItem(ItemInterface $item)
	{
		$matches = null;

		foreach ($this->voter as $voter) {
			$match = $voter->matchItem($item);

			if ($match !== null) {
				if ($match === 'never') {
					return false;
				}
				else if ($match === 'always') {
					return true;
				}
				else if ($matches === null) {
					$matches = $match;
				}
				else {
					$matches |= $match;
				}
			}
		}

		if ($matches !== null) {
			return $matches;
		}

		return $this->defaultMatch;
	}
}
