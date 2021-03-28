<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Contract;

use Ouxsoft\PHPMarkup\Engine;

/**
 * Interface BuilderInterface
 * Builders receive parameters passed from the Kernel and use them to instantiate and return a Document object.
 * @package Ouxsoft\PHPMarkup\Contract
 */
interface BuilderInterface
{
    public function __construct(EngineInterface &$engine, ConfigurationInterface &$config);

    public function createObject(): void;

    public function getObject(): Engine;
}
