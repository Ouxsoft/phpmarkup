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

namespace Ouxsoft\PHPMarkup\Element;

use Ouxsoft\PHPMarkup\ArgumentArray;
use Ouxsoft\PHPMarkup\Contract\EngineInterface;
use Ouxsoft\PHPMarkup\Exception\ParserException;

/**
 * Class Element
 *
 * An abstract class extended to instantiate Elements. During construction arguments and xml contained within
 * the Page's DomElement are passed to constructor.
 *
 * @package Ouxsoft\PHPMarkup\Element
 */
abstract class AbstractElement
{
    /**
     * @var EngineInterface the Engine processing the element
     */
    public $engine;

    /**
     * @var int|string the id used to reference object
     */
    public $element_id = 0;

    /**
     * @var int id used to load args
     * @deprecated
     */
    public $id = 0;

    /**
     * @var string the name of element
     */
    public $name = 'unknown';

    /**
     * @var array|ArgumentArray|null args passed to during construction
     * @deprecated
     */
    public $args = [];

    /**
     * @var array  tags used for filtering
     * @deprecated
     */
    public $tags = [];

    /**
     * @var bool render in search result builder
     */
    public $search_index = true;

    /**
     * @var array ancestor public variable updated live
     */
    public $ancestors = [];

    /**
     * @var string inner content updated live
     */
    public $xml = '';

    /**
     * Element constructor
     *
     * @param EngineInterface $engine
     * @param array $dynamic_properties additional class properties
     */
    final public function __construct(EngineInterface &$engine, array &$dynamic_properties = [])
    {
        $this->element_id = spl_object_hash($this);

        $this->engine = &$engine;

        // dynamic properties, used by application e.g. templating engine, database, etc.
        foreach ($dynamic_properties as $property_name => &$property_value) {
            if (property_exists($this, $property_name)) {
                throw new ParserException('Property already exists.');
            }
            $this->$property_name = &$property_value;
        }
    }

    /**
     * Call onRender if exists on echo / output
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->onRender();
    }

    /**
     * Abstract output method called by magic method
     * The extending class must define this method
     *
     * @return mixed
     */
    abstract public function onRender();

    /**
     * Gets the ID of the Element, useful for ElementPool
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->element_id;
    }

    /**
     * Get live arg by name if exists
     *
     * @param string $name
     * @return mixed|null
     */
    public function getArgByName(string $name)
    {
        $args = $this->getArgs();
        return $args[$name] ?? null;
    }

    /**
     * Get all live args
     *
     * @return ArgumentArray
     */
    public function getArgs(): ArgumentArray
    {
        return $this->engine->getArgsByElementId($this->element_id);
    }

    /**
     * Get sanitized innerText with args processing info removed
     *
     * @return string|null
     */
    public function innerText(): ?string
    {
        return $this->engine->sanitizeXml($this->xml);
        ;
    }

    /**
     * Invoke wrapper call to method if exists
     *
     * @param string $method
     * @return bool
     */
    public function __invoke(string $method): bool
    {
        // if method does not exist, return
        if (!method_exists($this, $method)) {
            return false;
        }

        // call element method
        call_user_func([
            $this,
            $method
        ]);

        return true;
    }
}
