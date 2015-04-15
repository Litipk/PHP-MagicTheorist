<?php


namespace Litipk\MagicTheorist;
use Litipk\MagicTheorist\Sets\Set;
use Litipk\MagicTheorist\Sets\SingletonSet;


/**
 * Class TheoreticBit
 * @package Litipk\MagicTheorist
 */
abstract class TheoreticBit
{
    /**
     * @return SingletonSet
     */
    public function getSingleton()
    {
        return new SingletonSet($this);
    }

    /**
     * Naive equality comparison
     *
     * @param TheoreticBit $other
     * @return boolean
     */
    public function equals(TheoreticBit $other)
    {
        return ($this === $other);
    }

    /**
     * Naive method to know if the element belongs to a set.
     *
     * @param  Set     $set
     * @param  Set     $fromSet Don't use this if you're not making the call from Set::contains.
     * @return boolean
     */
    public function belongsTo(Set $set, Set $fromSet=null)
    {
        if (null === $set) {
            throw new \InvalidArgumentException("\$set can't be null.");
        }

        if ($set === $fromSet || $fromSet !== null && isset($this->askedTo) && in_array($fromSet, $this->askedTo)) {
            // TODO: Change with a "IDontKnowException" or something similar
            throw new \LogicException("Endless loop");
        }

        if (!isset($this->askedTo)) {
            $this->askedTo = [];
        }
        $this->askedTo[] = $set;
        $result = $set->contains($this, $this);

        $this->askedTo = array_values(array_diff($this->askedTo, [$set]));
        if (empty($this->askedTo)) {
            unset($this->askedTo);
        }

        return $result;
    }
}
