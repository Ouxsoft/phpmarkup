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

use Ouxsoft\PHPMarkup\Contract\BuilderInterface;
use Ouxsoft\PHPMarkup\Contract\ConfigurationInterface;
use Ouxsoft\PHPMarkup\Contract\KernelInterface;

/**
 * Class Processor
 *
 * Provides a user API interface for setting the Kernel, Configuration, and Builders settings
 *
 * @package Ouxsoft\PHPMarkup
 */
class Processor
{
    /**
     * @var bool used to determine if process is active
     */
    private $active = true;

    /**
     * @var ConfigurationInterface
     */
    private $config;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Processor constructor.
     * @param KernelInterface $kernel
     * @param ConfigurationInterface $config
     */
    public function __construct(
        KernelInterface &$kernel,
        ConfigurationInterface &$config
    ) {
        $this->kernel = &$kernel;
        $this->config = &$config;
    }

    /**
     * Set whether process runs or does not run
     *
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->active = $status;
    }

    /**
     * Load config
     *
     * @param string $filepath
     */
    public function loadConfig(string $filepath): void
    {
        $this->config->loadFile($filepath);
    }

    /**
     * Get config
     *
     * @return ConfigurationInterface
     */
    public function getConfig(): ConfigurationInterface
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param ConfigurationInterface $config
     * @return void
     */
    public function setConfig(ConfigurationInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * Set builder
     *
     * @param string $builder_class
     */
    public function setBuilder(string $builder_class): void
    {
        $this->kernel->setBuilder($builder_class);
    }

    /**
     * Get builder
     *
     * @return BuilderInterface
     */
    public function getBuilder(): BuilderInterface
    {
        return $this->kernel->getBuilder();
    }

    /**
     * Add definition for processor LHTML element
     *
     * @param array $element
     */
    public function addElement(array $element): void
    {
        $this->config->addElement($element);
    }

    /**
     * Add definition for processor LHTML element
     *
     * @param array $elements
     */
    public function addElements(array $elements): void
    {
        $this->config->addElements($elements);
    }

    /**
     * Add a Property.
     * Properties are passed by reference to all Elements during initialization and become a property of that element
     * e.g. new Element($args, $properties)
     *
     * @param string $property_name
     * @param mixed $property_value
     */
    public function addProperty(string $property_name, &$property_value): void
    {
        $this->config->addProperty($property_name, $property_value);
    }

    /**
     * Add multiple Properties at once
     *
     * @param array $properties
     */
    public function addProperties(array &$properties): void
    {
        $this->config->addProperties($properties);
    }

    /**
     * Add definition for processor LHTML routine
     *
     * @param array $routine
     */
    public function addRoutine(array $routine): void
    {
        $this->config->addRoutine($routine);
    }

    /**
     * Add definition for processor LHTML routine
     *
     * @param array $routines
     */
    public function addRoutines(array $routines): void
    {
        $this->config->addRoutines($routines);
    }

    /**
     * Process output buffer
     */
    public function parseBuffer(): void
    {
        if ($this->getStatus()) {
            // process buffer once completed
            ob_start([$this, 'parseString']);
        }
    }

    /**
     * Gets whether process runs or does not run
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->active;
    }

    /**
     * Process a file
     *
     * @param string $filepath
     * @return string
     */
    public function parseFile(string $filepath): string
    {
        $source = file_get_contents($filepath);

        // return buffer if it's not HTML
        if ($source == strip_tags($source)) {
            return $source;
        }

        $this->config->setMarkup($source);

        return $this->parse();
    }

    /**
     * Parse using a Kernel to build an Engine
     *
     * @return string
     */
    private function parse(): string
    {
        return (string)$this->kernel->build();
    }

    /**
     * Process string
     *
     * @param string $source
     * @return string
     */
    public function parseString(string $source): string
    {
        // return buffer if it's not HTML
        if ($source == strip_tags($source)) {
            return $source;
        }

        $this->config->setMarkup($source);

        return $this->parse();
    }
}
