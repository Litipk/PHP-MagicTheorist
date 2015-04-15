<?php


namespace Litipk\MagicTheorist\Numbers;

use Litipk\Exceptions\NotImplementedException;
use Litipk\MagicTheorist\TheoreticBit;


/**
 * Class Number
 * Represents an element of a set in a context formed by an algebraic structure
 * @package Litipk\MagicTheorist\Numbers
 */
abstract class Number extends TheoreticBit
{
    /**
     * @var array
     */
    protected $known_sets = [];

    /**
     * @var
     */
    protected $known_algebraic_structures = [];

    /**
     * @var
     */
    protected $default_algebraic_structure = null;

    /**
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        throw new NotImplementedException();
    }

    /**
     * @param $name
     */
    public function __get($name)
    {
        throw new NotImplementedException();
    }
}
