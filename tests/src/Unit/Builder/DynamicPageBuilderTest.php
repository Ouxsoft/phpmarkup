<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Tests\Unit\Builder;

use Ouxsoft\PHPMarkup\Builder\DynamicPageBuilder;
use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;
use PHPUnit\Framework\TestCase;

class DynamicPageBuilderTest extends TestCase
{
    private $processor;

    public function setUp(): void
    {
        $this->processor = ProcessorFactory::getInstance();
        $this->processor->loadConfig(TEST_DIR . '/Resource/config/phpunit.json');
        $this->processor->setBuilder('DynamicPageBuilder');
    }

    public function tearDown(): void
    {
        unset($this->processor);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Builder\DynamicPageBuilder::__construct
     */
    public function test__construct()
    {
        $builder = $this->processor->getBuilder();
        $this->assertInstanceOf(DynamicPageBuilder::class, $builder);
    }

    /**
    * @covers \Ouxsoft\PHPMarkup\Builder\DynamicPageBuilder::getObject
    */
    public function testGetObject()
    {
        $test_results = $this->processor->parseFile(TEST_DIR . 'Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/dynamic-page.html',
            $test_results
        );
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Builder\DynamicPageBuilder::createObject
     */
    public function testCreateObject()
    {
        $test_results = $this->processor->parseFile(TEST_DIR . 'Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/dynamic-page.html',
            $test_results
        );
    }
}
