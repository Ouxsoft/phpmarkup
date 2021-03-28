<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Tests\Unit;

use Ouxsoft\PHPMarkup\Contract\BuilderInterface;
use Ouxsoft\PHPMarkup\Contract\ConfigurationInterface;
use Ouxsoft\PHPMarkup\Contract\KernelInterface;
use Ouxsoft\PHPMarkup\Engine;
use Ouxsoft\PHPMarkup\Configuration;
use Ouxsoft\PHPMarkup\Factory\ConcreteFactory;
use Ouxsoft\PHPMarkup\Factory\ContainerFactory;
use Ouxsoft\PHPMarkup\Document;
use PHPUnit\Framework\TestCase;
use Ouxsoft\PHPMarkup\Exception\Exception;

class KernelTest extends TestCase
{
    private $kernel;

    public function setUp(): void
    {
        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);

        //$container['config']->loadFile(TEST_DIR . 'Resource/config/phpunit.json');
        $container['config']->setMarkup('<html><p>Hello, World!</p></html>');
        $this->kernel = &$container['kernel'];
    }

    public function tearDown(): void
    {
        unset($this->kernel);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Kernel::__construct
     * @covers \Ouxsoft\PHPMarkup\Kernel
     */
    public function test__construct()
    {
        $this->assertInstanceOf(KernelInterface::class, $this->kernel);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Kernel::getConfig
     */
    public function testGetConfig()
    {
        $kernel_config = $this->kernel->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $kernel_config);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Kernel::setConfig
     */
    public function testSetConfig()
    {
        $document = new Document();
        $config = new Configuration($document);
        $this->kernel->setConfig($config);
        $kernel_config = $this->kernel->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $kernel_config);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Kernel::setBuilder
     */
    public function testSetBuilder()
    {
        $this->kernel->setBuilder('SearchIndexBuilder');
        $engine = $this->kernel->build();
        $this->assertInstanceOf(Engine::class, $engine);

        // try a class that doesn't exists
        $this->expectException(Exception::class);
        $this->kernel->setBuilder('DoesNotExists');

        // try a class that is doesn't implement BuilderInterface
        $this->expectException(Exception::class);
        $this->kernel->setBuilder('ElementPool');
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Kernel::getBuilder
     */
    public function testGetBuilder()
    {
        $builder = $this->kernel->getBuilder();
        $this->assertInstanceOf(BuilderInterface::class, $builder);
    }


    /**
     * @covers \Ouxsoft\PHPMarkup\Kernel::build
     */
    public function testBuild()
    {
        $engine = $this->kernel->build();
        $this->assertInstanceOf(Engine::class, $engine);
    }
}
