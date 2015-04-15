<?php


namespace Litipk\MagicTheorist\Numbers;
use Litipk\Exceptions\InvalidArgumentTypeException;

/**
 * Class GmpInteger
 * Represents an integer number (not to be confused with the Integers set). Implemented with GMP.
 *
 * @package Litipk\MagicTheorist\Numbers
 */
class GmpInteger extends Integer
{
    /**
     * Holds the GMP resource/object reference.
     *
     * @var resource|\GMP
     */
    private $gmp_object = null;

    /**
     * Holds a string representation (using base 10).
     *
     * @var null|string
     */
    private $str_value = null;

    /**
     * Holds a PHP's native int representation (if possible)
     *
     * @var null|string
     */
    private $int_value = null;

    /**
     * Creates a new GmpInteger object.
     *
     * @param int|string|resource|\GMP|Integer $value
     * @param int $base
     *
     * @throws InvalidArgumentTypeException If the $value type is not int, string,
     *                                      resource("GMP Integer"),\GMP or Integer.
     */
    public function __construct($value, $base = 10)
    {
        if (is_int($value)) {
            $this->gmp_object = gmp_init($value);
            $this->int_value = $value;
        } elseif(is_string($value)) {
            $this->checkBase($base);

            $this->gmp_object = gmp_init($value, $base);

            if ($this->gmp_object === false) {
                throw new \InvalidArgumentException("Invalid string passed to construct");
            }

            if ($base === 10) {
                $this->str_value = $value;
            }
        } elseif($value instanceof \GMP || is_resource($value) && "GMP integer" === get_resource_type($value)) {
            $this->gmp_object = $value;
        } elseif ($value instanceof BcInteger) {
            $this->str_value = $value->__toString();
            $this->gmp_object = gmp_init($this->str_value);
        } elseif ($value instanceof GmpInteger) {
            $this->gmp_object = $value->gmp_object;
        } else {
            throw new InvalidArgumentTypeException(["int", "string", "\\GMP", "resource", "Integer"], gettype($value));
        }
    }

    /**
     * Handles GMP resource serialization in case we're using PHP < 5.6
     */
    public function __sleep()
    {
        if (is_resource($this->gmp_object)) {
            $this->str_value = gmp_strval($this->gmp_object);
            return ["serialized_gmp_object"];
        } elseif ($this->gmp_object instanceof \GMP) {
            return ["gmp_object", "serialized_gmp_object"];
        }
    }

    /**
     * Handles GMP resource un-serialization in case we're using PHP < 5.6
     */
    public function __wakeup()
    {
        if ($this->str_value !== null && !($this->gmp_object instanceof \GMP)) {
            $this->gmp_object = gmp_init($this->str_value);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (null === $this->str_value) {
            $this->str_value = gmp_strval($this->gmp_object);
        }

        return $this->str_value;
    }

    public function toString($base = 10)
    {
        $this->checkBase($base);

        if (10 === $base) {
            return $this->__toString();
        }

        $result = gmp_strval($this->gmp_object, $base);

        if (2 === $base) {
            $this->preppendPrefix($result, '0b');
        } elseif (8 === $base) {
            $this->preppendPrefix($result, '0');
        } elseif (16 === $base) {
            $this->preppendPrefix($result, '0x');
        }

        return $result;
    }

    public function toInt()
    {
        if (null !== $this->int_value) {
            return $this->int_value;
        }

        if (gmp_cmp($this->gmp_object, PHP_INT_MAX) <= 0 && gmp_cmp($this->gmp_object, -PHP_INT_MAX-1) >= 0) {
            $this->int_value = gmp_intval($this->gmp_object);
            return $this->int_value;
        }

        throw new \RangeException("The integer value is too big to put it inside an int variable.");
    }

    /**
     * @return \GMP|resource
     */
    public function toGmp()
    {
        return $this->gmp_object;
    }

    /**
     * @param $str_number
     * @param $prefix
     * @return string
     */
    private function preppendPrefix(&$str_number, $prefix)
    {
        if ('-' === $str_number[0]) {
            $is_negative = true;
            $str_number = substr($str_number, 1);
        } else {
            $is_negative = false;
        }

        $str_number = ($is_negative ? '-' : '').$prefix.$str_number;
    }
}
