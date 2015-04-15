<?php


namespace Litipk\MagicTheorist\Sets;


use Litipk\Exceptions\NotImplementedException;
use Litipk\MagicTheorist\TheoreticBit;

class EmptySet extends Set
{

    public function getCardinality()
    {
        throw new NotImplementedException();
    }

    public function getPowerSet()
    {
        return $this;
    }

    public function isSubsetOf(Set $otherSet)
    {
        return true;
    }

    public function isSuperSetOf(Set $otherSet)
    {
        return ($otherSet instanceof EmptySet);
    }

    public function isPowerSetOf(Set $otherSet)
    {
        return ($otherSet instanceof EmptySet);
    }

    public function contains(TheoreticBit $element)
    {
        return false;
    }
}
