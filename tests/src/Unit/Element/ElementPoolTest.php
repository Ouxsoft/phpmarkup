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

use ArrayIterator;
use Ouxsoft\PHPMarkup\Element\AbstractElement;
use Ouxsoft\PHPMarkup\Element\ElementPool;
use Ouxsoft\PHPMarkup\Engine;
use Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld;
use PHPUnit\Framework\TestCase;

class ElementPoolTest extends TestCase
{
    /**
     * @covers \Ouxsoft\PHPMarkup\Element\ElementPool::getIterator
     */
    public function testGetIterator()
    {
        $pool = new ElementPool();
        $this->assertTrue(($pool->getIterator() instanceof ArrayIterator));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\ElementPool::getPropertiesById
     */
    public function testGetPropertiesById()
    {
        $stub = $this->createStub(Engine::class);
        $pool = new ElementPool();
        $lhtml_element = new HelloWorld($stub);
        $pool->add($lhtml_element);
        $this->assertIsArray($pool->getPropertiesById($lhtml_element->element_id));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\ElementPool::getById
     */
    public function testGetById()
    {
        $stub = $this->createStub(Engine::class);
        $pool = new ElementPool();
        $lhtml_element = new HelloWorld($stub);
        $pool->add($lhtml_element);
        $this->assertTrue(($pool->getById($lhtml_element->element_id) instanceof AbstractElement));

        $this->assertFalse(($pool->getById('missing') instanceof AbstractElement));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\ElementPool::add
     */
    public function testAdd()
    {
        $stub = $this->createStub(Engine::class);
        $pool = new ElementPool();
        $lhtml_element = new HelloWorld($stub);
        $pool->add($lhtml_element);
        $this->assertTrue(($pool->getById($lhtml_element->element_id) instanceof AbstractElement));
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\ElementPool::callRoutine
     */
    public function testCallRoutine()
    {
        $pool = new ElementPool();
        $results = $pool->callRoutine('onRender');
        $this->assertNull($results);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\Element\ElementPool::count
     */
    public function testCount()
    {
        $stub = $this->createStub(Engine::class);
        $pool = new ElementPool();
        $lhtml_element = new HelloWorld($stub);
        $pool->add($lhtml_element);
        $this->assertCount(1, $pool);
    }
}
