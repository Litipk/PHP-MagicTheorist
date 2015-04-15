<?php


namespace Litipk\MagicTheorist\Sets\NamedSets;

use Litipk\Exceptions\NotImplementedException;
use Litipk\MagicTheorist\Numbers\Integer;
use Litipk\MagicTheorist\TheoreticBit;
use Litipk\MagicTheorist\Sets\Set;


class Integers extends Set
{
    public function getCardinality()
    {
        throw new NotImplementedException();
    }

    public function isSubsetOf(Set $otherSet)
    {
        throw new NotImplementedException();
    }

    public function isSuperSetOf(Set $otherSet)
    {
        throw new NotImplementedException();
    }

    public function contains(TheoreticBit $element)
    {
        // TODO : Improve (using "Properties" and Sets)
        return ($element instanceof Integer);
    }
}
