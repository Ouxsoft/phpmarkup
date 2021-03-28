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

use Ouxsoft\PHPMarkup\Contract\BuilderInterface;
use Ouxsoft\PHPMarkup\Configuration;
use Ouxsoft\PHPMarkup\Document;
use Ouxsoft\PHPMarkup\Element\ElementPool;
use Ouxsoft\PHPMarkup\Engine;
use Ouxsoft\PHPMarkup\Kernel;
use Pimple\Container;

/**
 * Interface AbstractFactoryInterface
 * @package Ouxsoft\PHPMarkup\Contract
 */
interface AbstractFactoryInterface
{
    /**
     * @param Container $container
     * @return Document
     */
    public function makeDocument(Container &$container): DocumentInterface;

    /**
     * @param Container $container
     * @return Configuration
     */
    public function makeConfig(Container &$container): Configuration;

    /**
     * @return ElementPool
     */
    public function makeElementPool(): ElementPool;

    /**
     * @param Container $container
     * @return BuilderInterface
     */
    public function makeBuilder(Container &$container): BuilderInterface;

    /**
     * @param Container $container
     * @return Engine
     */
    public function makeEngine(Container &$container): Engine;

    /**
     * @param Container $container
     * @return Kernel
     */
    public function makeKernel(Container &$container): Kernel;
}
