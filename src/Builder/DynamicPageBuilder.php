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

namespace Ouxsoft\PHPMarkup\Builder;

use Ouxsoft\PHPMarkup\Contract\BuilderInterface;
use Ouxsoft\PHPMarkup\Contract\ConfigurationInterface;
use Ouxsoft\PHPMarkup\Contract\EngineInterface;
use Ouxsoft\PHPMarkup\Engine;

/**
 * Class DynamicPageBuilder
 * Builds dynamic pages
 *
 * @package Ouxsoft\PHPMarkup\Page\Builder
 */
class DynamicPageBuilder implements BuilderInterface
{
    private $engine;
    /**
     * @var ConfigurationInterface
     */
    private $config;

    public function __construct(EngineInterface &$engine, ConfigurationInterface &$config)
    {
        $this->engine = &$engine;
        $this->config = &$config;
    }

    /**
     * Instantiate elements and call routines inside engine
     *
     * @return void
     */
    public function createObject(): void
    {
        // instantiate elements
        foreach ($this->config->getElements() as $element) {
            $this->engine->instantiateElements($element);
        }

        // call element routine
        foreach ($this->config->getRoutines() as $routine) {
            $this->engine->callRoutine($routine);
        }
    }

    /**
     * Gets Page object
     *
     * @return Engine
     */
    public function getObject(): Engine
    {
        return $this->engine;
    }
}
