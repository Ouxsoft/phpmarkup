<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ouxsoft\PHPMarkup;

use ArrayAccess;
use Iterator;
use Countable;

/**
 * Class ArgumentArray contains Element arguments
 *
 * @package Ouxsoft\PHPMarkup
 */
class ArgumentArray implements
    ArrayAccess,
    Iterator,
    Countable
{
    private $container = [];

    private $index = 0;

    /**
     * Returns count of containers
     * @return int
     */
    public function count(): int
    {
        return count($this->container);
    }

    /**
     * Check if item exists inside container
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Get item from container
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Adds new item to array, if only one item in array then it will be a string
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!isset($this->container[$offset])) {
            // set value
            $this->container[$offset] = $value;
        } elseif ($this->container[$offset] == $value) {
            // if item value exists as string skip
        } elseif (is_string($this->container[$offset])) {
            // change string value to array
            $present_value = $this->container[$offset];
            $this->container[$offset] = [];
            array_push($this->container[$offset], $present_value);
            array_push($this->container[$offset], $value);
        } elseif (in_array($value, $this->container[$offset])) {
            // if item already exists return
            return;
        } elseif (is_array($this->container[$offset])) {
            // add to array
            array_push($this->container[$offset], $value);
        }
    }

    /**
     * Remove item from container
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Return container property
     *
     * @return array
     */
    public function get(): array
    {
        return $this->container;
    }

    /**
     * Merge array passed with container property
     *
     * @param $array
     */
    public function merge($array): void
    {
        $this->container = array_merge($array, $this->container);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        $k = array_keys($this->container);
        return $this->container[$k[$this->index]];
    }

    /**
     * @return bool|mixed|void
     */
    public function next()
    {
        $k = array_keys($this->container);
        if (isset($k[++$this->index])) {
            return $this->container[$k[$this->index]];
        } else {
            return false;
        }
    }

    /**
     * @return bool|float|int|mixed|string|null
     */
    public function key()
    {
        $k = array_keys($this->container);
        return $k[$this->index];
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $k = array_keys($this->container);
        return isset($k[$this->index]);
    }

    public function rewind()
    {
        $this->index = 0;
    }
}
