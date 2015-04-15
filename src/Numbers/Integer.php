<?php


namespace Litipk\MagicTheorist\Numbers;

use Litipk\Exceptions\InvalidArgumentTypeException;
use Litipk\MagicTheorist\AlgebraicStructures\AlgebraicStructure;
use Litipk\MagicTheorist\TheoreticStructure;


/**
 * Class Integer
 * Represents an integer number (not to be confused with the Integers set).
 * @package Litipk\MagicTheorist\Numbers
 */
abstract class Integer extends Number
{
    /**
     * @param $value
     * @param int $base
     * @param TheoreticStructure $theoreticStructure
     * @return BcInteger|GmpInteger
     */
    public static function create($value, $base = 10, TheoreticStructure $theoreticStructure = null)
    {
        if (extension_loaded("gmp")) {
            return new GmpInteger($value, $base, $theoreticStructure);
        } else if (extension_loaded("bcmath")) {
            return new BcInteger($value, $base, $theoreticStructure);
        } elseif ($value instanceof Integer) {
            return $value;
        }else {
            throw new \LogicException("Unable to find GMP or BcMath extensions.");
        }
    }

    /**
     * @return mixed
     */
    public abstract function __toString();

    /**
     * Similar to __toString, but you can specify a numeric base to represent the number.
     *
     * @param int $base
     * @return string
     */
    public abstract function toString($base = 10);

    /**
     * Returns a PHP's native int value representing the same number the object is representing.
     *
     * @return int
     *
     * @throws \RangeException if the internal value is too "big".
     */
    public abstract function toInt();

    /**
     * Checks if the $base parameter is correct.
     * @param int $base
     */
    protected function checkBase($base)
    {
        if (!is_int($base)) {
            throw new InvalidArgumentTypeException(["int"], gettype($base));
        }
        if ($base < 2 || $base > 36) {
            throw new \RangeException('$base must be in the interval [2, 36]');
        }
    }
}
