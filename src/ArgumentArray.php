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
 *     {
 *       "limit" : 1,
 *       "items" : ["apple","orange","grape"]
 *     }
 *
 * @package Ouxsoft\PHPMarkup
 */
class ArgumentArray implements
    ArrayAccess,
    Iterator,
    Countable
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * @var int the position in the array keys
     *
     * e.g. 2 would represent c {"a":[1,2,3],"b","c"}
     */
    private $index = 0;

    /**
     * @var array keys contain a list of arrays stored
     */
    private $keys = [];

    /**
     * Set a value type to avoid Type Juggling issues and extend data types
     *
     * @param string $name
     * @param string|null $value
     * @param string|null $type
     * @return void
     */
    public function set(string $name, string $value = null, ?string $type = null): void
    {
        $type = strtolower($type);

        switch ($type) {
            case 'string':
            case 'str':
                $value = (string)$value;
                break;
            case 'json':
                $value = json_decode($value);
                break;
            case 'int':
            case 'integer':
                $value = (int)$value;
                break;
            case 'float':
                $value = (float)$value;
                break;
            case 'bool':
            case 'boolean':
                $value = (bool)$value;
                break;
            case 'null':
                $value = null;
                break;
            case 'list':
                $value = explode(',', $value);
                break;
            default:
                // no transform
                break;
        }

        $this->container[$name] = $value;
    }

    /**
     * Returns count of containers
     *
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
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    /**
     * Adds new item to array, if only one item in array then it will be a string
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $offset = strval($offset);

        // set value if value not set
        if (!isset($this->container[$offset])) {
            $this->container[$offset] = $value;
            return;
        }

        // if item value exists and is same do nothing
        if ($this->container[$offset] == $value) {
            return;
        }

        // if not an array change to one and add value
        if (
            isset($this->container[$offset])
            && !is_array($this->container[$offset])
        ) {
            $present_value = $this->container[$offset];
            $this->container[$offset] = [];
            array_push($this->container[$offset], $present_value);
            array_push($this->container[$offset], $value);
            return;
        }

        // if item already exists return
        if (in_array($value, $this->container[$offset])) {
            return;
        }

        // add to array
        if (
            is_array($this->container[$offset])
            && !in_array($value, $this->container[$offset])
        ) {
            array_push($this->container[$offset], $value);
            return;
        }
    }

    /**
     * Remove item from container
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $offset = strval($offset);
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
     * @param array $array
     */
    public function merge(array $array): void
    {
        $this->container = array_merge($array, $this->container);
    }

    public function current()
    {
        $current_key = $this->getCurrentKey();
        return $this->container[$current_key];
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $this->index++;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->getCurrentKey();
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        $current_key = $this->getCurrentKey();
        return isset($this->container[$current_key]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * @return string
     */
    private function getCurrentKey(): ?string
    {
        $args = array_keys($this->container);
        return $args[$this->index] ?? null;
    }
}
