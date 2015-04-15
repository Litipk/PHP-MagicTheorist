<?php


namespace Litipk\MagicTheorist\Sets;


use Litipk\MagicTheorist\Numbers\Integer;
use Litipk\MagicTheorist\TheoreticBit;

class SingletonSet extends Set
{
    /**
     * @var TheoreticBit
     */
    private $value;

    /**
     * @param TheoreticBit $value
     */
    public function __construct(TheoreticBit $value)
    {
        if (null === $value) {
            throw new \InvalidArgumentException("\$value can't be null.");
        }

        if ($this === $value) {
            throw new \LogicException("I don't know how did you this, but it's utterly crap.");
        }

        $this->value = $value;
    }

    public function getCardinality()
    {
        return Integer::create(1); // TODO : Convert to Cardinals...
    }

    public function isSubsetOf(Set $otherSet)
    {
        // TODO: Implement isSubsetOf() method.
    }

    public function isSuperSetOf(Set $otherSet)
    {
        // TODO: Implement isSuperSetOf() method.
    }

    public function contains(TheoreticBit $element)
    {
        return $element->equals($this->value);
    }
}
