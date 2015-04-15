<?php


namespace Litipk\MagicTheorist\Sets;

use Litipk\MagicTheorist\TheoreticBit;
use Litipk\MagicTheorist\TheoreticStructure;


abstract class Set extends TheoreticStructure
{
    public abstract function getCardinality();

    public abstract function isSubsetOf(Set $otherSet);
    public abstract function isSuperSetOf(Set $otherSet);

    /**
     * Naive method to know if the set contains an element.
     *
     * @param  TheoreticBit     $element
     * @param  TheoreticBit     $fromElement Don't use this if you're not making the call from Set::contains.
     * @return boolean
     */
    public function contains(TheoreticBit $element, TheoreticBit $fromElement=null)
    {
        if (null === $element) {
            throw new \InvalidArgumentException("\$element can't be null.");
        }

        if ($element === $fromElement || $fromElement !== null && isset($this->askedTo) && in_array($fromElement, $this->askedTo)) {
            // TODO: Change with a "IDontKnowException" or something similar
            throw new \LogicException("Endless loop");
        }

        if (!isset($this->askedTo)) {
            $this->askedTo = [];
        }
        $this->askedTo[] = $element;
        $result = $element->belongsTo($this, $this);

        $this->askedTo = array_values(array_diff($this->askedTo, [$element]));
        if (empty($this->askedTo)) {
            unset($this->askedTo);
        }

        return $result;
    }
}
