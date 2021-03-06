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

use Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld;
use PHPUnit\Framework\TestCase;

class AbstractElementTest extends TestCase
{
    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::getArgByName
     */
    public function testGetArgByName()
    {
        $element = new HelloWorld();
        $element->args['test'] = 'pass';
        $this->assertEquals('pass', $element->getArgByName('test'));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::__construct
     */
    public function test__construct()
    {
        $element = new HelloWorld();
        $this->assertTrue(isset($element->element_id));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::onRender
     */
    public function testOnRender()
    {
        $element = new HelloWorld();
        $this->assertTrue($element('onRender'));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::__invoke
     */
    public function test__invoke()
    {
        $element = new HelloWorld();
        $this->assertTrue($element('onRender'));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::innerText
     */
    public function testInnerText()
    {
        $element = new HelloWorld();
        $element->xml = 'pass';
        $this->assertStringContainsString($element->innerText(), 'pass');
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::__toString
     */
    public function test__toString()
    {
        $element = new HelloWorld();
        $this->assertStringContainsString('Hello, World', $element);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::getArgs
     */
    public function testGetArgs()
    {
        $element = new HelloWorld();
        $element->args['test'] = 'pass';
        $this->assertArrayHasKey('test', $element->getArgs());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\AbstractElement::getId
     */
    public function testGetId()
    {
        $element = new HelloWorld();
        $this->assertIsString($element->getId());
    }
}
