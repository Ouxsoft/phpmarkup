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

namespace Ouxsoft\PHPMarkup\Factory;

use Ouxsoft\PHPMarkup\Contract\AbstractFactoryInterface;
use Ouxsoft\PHPMarkup\Contract\BuilderInterface;
use Ouxsoft\PHPMarkup\Contract\DocumentInterface;
use Ouxsoft\PHPMarkup\Builder\DynamicPageBuilder;
use Ouxsoft\PHPMarkup\Configuration;
use Ouxsoft\PHPMarkup\Document;
use Ouxsoft\PHPMarkup\Element\ElementPool;
use Ouxsoft\PHPMarkup\Engine;
use Ouxsoft\PHPMarkup\Kernel;
use Pimple\Container;

class ConcreteFactory implements AbstractFactoryInterface
{
    public function makeDocument(Container &$container): DocumentInterface
    {
        return new Document();
    }


    public function makeConfig(Container &$container): Configuration
    {
        return new Configuration(
            $container['document']
        );
    }

    public function makeElementPool(): ElementPool
    {
        return new ElementPool();
    }


    public function makeBuilder(Container &$container): BuilderInterface
    {
        return new DynamicPageBuilder(
            $container['engine'],
            $container['config']
        );
    }

    public function makeEngine(Container &$container): Engine
    {
        return new Engine(
            $container['document'],
            $container['element_pool'],
            $container['config']
        );
    }

    public function makeKernel(Container &$container): Kernel
    {
        return new Kernel(
            $container['engine'],
            $container['builder'],
            $container['config']
        );
    }
}
