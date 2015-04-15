<?php


namespace Litipk\MagicTheorist\Sets;

use Litipk\MagicTheorist\TheoreticBit as TheoreticBit;


abstract class Set extends TheoreticBit
{
    public abstract function getCardinality();
    public abstract function getPowerSet();

    public abstract function isSubsetOf(Set $otherSet);
    public abstract function isSuperSetOf(Set $otherSet);
    public abstract function isPowerSetOf(Set $otherSet);

    public abstract function contains(TheoreticBit $element);
}
