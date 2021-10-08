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

use Ouxsoft\PHPMarkup\Element\ElementPool;
use Ouxsoft\PHPMarkup\Engine;
use Ouxsoft\PHPMarkup\Exception\ParserException;
use Ouxsoft\PHPMarkup\Factory\ConcreteFactory;
use Ouxsoft\PHPMarkup\Factory\ContainerFactory;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    private $engine;
    private $config;

    public function setUp(): void
    {
        $abstractFactory = new ConcreteFactory();
        $container = ContainerFactory::buildContainer($abstractFactory);
        $this->engine = &$container['engine'];
        $this->config = &$container['config'];
    }

    public function tearDown(): void
    {
        unset($this->engine);
    }
    
    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::queryFetchAll
     */
    public function testQueryFetchAll()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $results = $this->engine->queryFetchAll('//*');
        $this->assertCount(2, $results);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::getDomElementByPlaceholderId
     */
    public function testGetDomElementByPlaceholderId()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test">Hello, World!</b></html>');
        $results = $this->engine->getDomElementByPlaceholderId('test');
        $bool = $results->getAttribute(Engine::INDEX_ATTRIBUTE) == 'test';
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::getElementInnerXML
     */
    public function testGetElementInnerXML()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test">Hello, World!</b></html>');
        $results = $this->engine->getElementInnerXML('test');
        $bool = $results == 'Hello, World!';
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::getElementArgs
     */
    public function testGetElementArgs()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test"><arg name="toggle">no</arg><arg name="">empty</arg></b></html>');
        $dom_element = $this->engine->getDomElementByPlaceholderId('test');
        $args = $this->engine->getElementArgs($dom_element);
        $bool = $args['toggle'] == 'no';
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::__toString
     */
    public function test__toString()
    {
        $this->config->setMarkup('<html lang="en"><b><arg name="toggle">no</arg></b></html>');
        $engine = (string)$this->engine;
        $engine = $this->removeWhitespace($engine);
        $test_results = '<!DOCTYPE html><html lang="en"><b><arg name="toggle">no</arg></b></html>';
        $this->assertEquals($engine, $test_results);
    }

    /**
     * Removes whitespace to allow testing from multiple OS
     * @param string $string
     * @return string
     */
    public function removeWhitespace(string $string): string
    {
        return preg_replace('~\R~u', '', $string);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::queryFetch
     */
    public function testQueryFetch()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $results = $this->engine->queryFetch('//*');
        $this->assertEquals('Hello, World!', $results->nodeValue);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::instantiateElements
     */
    public function testInstantiateElements()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//b',
                'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        $this->assertCount(1, $this->engine->element_pool);

        $this->engine->instantiateElements(
            [
                'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );

        $bool = $this->engine->instantiateElements([]);

        $this->assertFalse($bool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::callRoutine
     */
    public function testCallRoutine()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//b',
                'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        $bool = $this->engine->callRoutine([
            'name' => 'onRender',
            'execute' => 'RETURN_CALL'
        ]);
        $this->assertTrue($bool);

        $throw_occurred = false;
        try {
            // test throw
            $this->engine->callRoutine([
                'name' => 'onRender',
                'execute' => 'THROW_ERROR'
            ]);
        } catch (ParserException $e) {
            $throw_occurred = true;
        }
        $this->assertTrue($throw_occurred);
    }


    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::replaceDomElement
     */
    public function testReplaceDomElement()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test"><arg name="toggle">no</arg></b></html>');
        $dom_element = $this->engine->getDomElementByPlaceholderId('test');
        $this->engine->replaceDomElement($dom_element, '<b>Foo Bar</b>');
        $engine_output = $this->removeWhitespace($this->engine);
        $this->assertStringContainsString(
            $engine_output,
            '<!DOCTYPE html><html lang="en"><b>Foo Bar</b></html>'
        );
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::renderElement
     */
    public function testRenderElement()
    {
        $this->config->setMarkup('<html lang="en"><div>Foo Bar</div></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        foreach ($this->engine->element_pool as $element) {
            $this->engine->renderElement($element->element_id);
        }

        $engine_output = $this->removeWhitespace($this->engine);

        $this->assertStringContainsString(
            $engine_output,
            '<!DOCTYPE html><html lang="en">Hello, World</html>'
        );

        // try tendering invalid element
        $bool = $this->engine->renderElement('2');
        $this->assertFalse($bool);
    }

    /**
     * private class cannot test directly, instead we're using InstantiateElements
     * @covers \Ouxsoft\PHPMarkup\Engine::instantiateElement
     */
    public function testInstantiateElement()
    {
        $this->config->setMarkup('
<html lang="en">
    <div ' . Engine::INDEX_ATTRIBUTE . '="skip">
        Skip
    </div>
    <div name="HelloWorld" type="page">
        <arg name="section">help</arg>
        <div>Hello, World!</div>
    </div>
    <em name="test">Foo Bar</em>
</html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\{name}'
            ]
        );
        $this->engine->instantiateElements([
            'xpath' => '//em',
            'class_name' => 'Missing'
        ]);

        $this->assertCount(1, $this->engine->element_pool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::getElementAncestorProperties
     */
    public function testGetElementAncestorProperties()
    {
        $this->config->setMarkup('<html lang="en"><div type="page"><arg name="section">help</arg><div>Hello, World!</div></div></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        foreach ($this->engine->element_pool as $element) {
            $properties = $this->engine->getElementAncestorProperties($element->element_id);
            $this->assertIsArray($properties);
        }
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Engine::__construct
     */
    public function test__construct()
    {
        $bool = $this->engine->element_pool instanceof ElementPool;
        $this->assertTrue($bool);
    }
}
