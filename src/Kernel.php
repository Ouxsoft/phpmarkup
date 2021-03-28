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
use Ouxsoft\PHPMarkup\Contract\EngineInterface;
use Ouxsoft\PHPMarkup\Contract\KernelInterface;
use Ouxsoft\PHPMarkup\Exception\Exception;

/**
 * Class Kernel
 *
 * The Kernel passes a Configuration through a Builder to build a Engine
 *
 * @package Ouxsoft\PHPMarkup
 */
class Kernel implements KernelInterface
{
    private $engine;
    private $builder;
    private $config;

    /**
     * Kernel constructor.
     * @param EngineInterface $engine
     * @param BuilderInterface $builder
     * @param ConfigurationInterface $config
     */
    public function __construct(
        EngineInterface &$engine,
        BuilderInterface &$builder,
        ConfigurationInterface &$config
    ) {
        $this->engine = &$engine;
        $this->builder = &$builder;
        $this->config = &$config;
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
     */
    public function setConfig(ConfigurationInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * Get builder
     *
     * @return BuilderInterface
     */
    public function getBuilder(): BuilderInterface
    {
        return $this->builder;
    }

    /**
     * Set builder
     *
     * @param string $builder_class
     */
    public function setBuilder(string $builder_class): void
    {
        $builder_class = 'Ouxsoft\\PHPMarkup\\Builder\\' . $builder_class;

        if (!class_exists($builder_class)) {
            throw new Exception('Builder class "' . $builder_class . '" does not exists');
        }

        $this->builder = new $builder_class(
            $this->engine,
            $this->config
        );
    }

    /**
     * Calls Builder using parameters supplied
     * @return Engine
     */
    public function build(): Engine
    {
        $this->builder->createObject();

        return $this->builder->getObject();
    }
}
