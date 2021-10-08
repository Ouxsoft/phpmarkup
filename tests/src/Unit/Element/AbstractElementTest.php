<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Tests\Unit\Element;

use Ouxsoft\PHPMarkup\Engine;
use Ouxsoft\PHPMarkup\ArgumentArray;
use Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld;
use PHPUnit\Framework\TestCase;

class AbstractElementTest extends TestCase
{
    /**
     * @var HelloWorld
     */
    private $element;

    public function setUp(): void
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';

        $stub = $this->createStub(Engine::class);
        $stub->method('getArgsByElementId')
            ->willReturn($args);

        $this->element = new HelloWorld($stub);
    }

    public function tearDown(): void
    {
        unset($this->element);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::getArgByName
     */
    public function testGetArgByName()
    {
        $this->element->args['test'] = 'pass';
        $this->assertEquals('pass', $this->element->getArgByName('test'));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::__construct
     */
    public function test__construct()
    {
        $this->assertTrue(isset($this->element->element_id));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::onRender
     */
    public function testOnRender()
    {
        $result = $this->element->onRender();
        $this->assertEquals('Hello, World', $result);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::__invoke
     */
    public function test__invoke()
    {
        $stub = $this->createStub(Engine::class);
        $element = new HelloWorld($stub);
        $result = $element('onRender');
        $this->assertTrue($result);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::innerText
     */
    public function testInnerText()
    {
        $this->element->xml = 'pass';
        $this->assertStringContainsString($this->element->innerText(), 'pass');

        // test to args removed
        $this->element->xml = '<arg>Hello, World</arg>';
        $this->assertStringNotContainsString('arg', $this->element->innerText());

        // test to ensure INDEX_ATTRIBUTE removed
        $this->element->xml = "<div {Engine::INDEX_ATTRIBUTE}<arg>Hello, World</arg>";
        $this->assertStringNotContainsString(Engine::INDEX_ATTRIBUTE, $this->element->innerText());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::__toString
     */
    public function test__toString()
    {
        $this->assertStringContainsString('Hello, World', $this->element);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::getArgs
     */
    public function testGetArgs()
    {
        $this->assertArrayHasKey('test', $this->element->getArgs());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::getId
     */
    public function testGetId()
    {
        $this->assertIsString($this->element->getId());
    }
}
