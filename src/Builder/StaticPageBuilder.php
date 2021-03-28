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
 * Class StaticPageBuilder
 * Builds static pages without any elements being set
 *
 * @package Ouxsoft\PHPMarkup\Page\Builder
 */
class StaticPageBuilder implements BuilderInterface
{
    private $engine;

    public function __construct(EngineInterface &$engine, ConfigurationInterface &$config)
    {
        $this->engine = &$engine;
        $this->config = &$config;
    }

    /**
     * Creates Page object using parameters supplied
     *
     * @return void
     */
    public function createObject(): void
    {
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
