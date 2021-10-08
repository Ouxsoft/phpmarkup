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

use Ouxsoft\PHPMarkup\ArgumentArray;
use PhpParser\Node\Arg;
use PHPUnit\Framework\TestCase;

class ArgumentArrayTest extends TestCase
{
    /**
     * @var ArgumentArray
     */
    public $args;

    public function setUp(): void
    {
        $this->args = new ArgumentArray();
    }

    public function tearDown(): void
    {
        unset($this->args);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::set
     */
    public function testSet()
    {
        $this->args->set('a', '0', 'string');
        $this->assertIsString($this->args['a']);

        $this->args->set('a', '2', 'int');
        $this->assertIsInt($this->args['a']);

        $this->args->set('a', '1', 'bool');
        $this->assertIsBool($this->args['a']);

        $this->args->set('a', '1.1', 'float');
        $this->assertIsFloat($this->args['a']);

        $this->args->set('a', '', 'null');
        $this->assertNull($this->args['a']);

        $this->args->set('a', 'Cat,Dog,Pig', 'list');
        $this->assertIsArray($this->args['a']);

        $this->args->set('a', '["Cat","Dog","Pig"]', 'json');
        $this->assertIsArray($this->args['a']);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::count
     */
    public function testCount()
    {
        $this->args->offsetSet('1', 'test');
        $this->assertCount(1, $this->args);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetSet
     */
    public function testOffsetSet()
    {
        $this->args->offsetSet('1', 'test');
        $this->assertCount(1, $this->args);

        // check to make sure only one item exists
        $this->args->offsetSet('1', 'test');
        $this->assertCount(1, $this->args);


        // check to see if it turns key into an array
        $this->args->offsetSet('1', 'test_2');
        $this->assertCount(1, $this->args);
        $this->assertIsArray($this->args['1']);

        // check to make sure duplicated item isn't added to array
        $this->args->offsetSet('1', 'test_2');
        $this->assertCount(1, $this->args);


        // check if item added to array
        $this->args->offsetSet('1', 'test3');
        $this->assertCount(1, $this->args);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetExists
     */
    public function testOffsetExists()
    {
        $this->args->offsetSet('1', 'test');
        $bool = $this->args->offsetExists(1);
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::get
     */
    public function testGet()
    {
        $this->args['test'] = 'pass';
        $this->assertArrayHasKey('test', $this->args->get());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetGet
     */
    public function testOffsetGet()
    {
        $this->args['test'] = 'pass';
        $this->assertStringContainsString($this->args->offsetGet('test'), 'pass');
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetUnset
     */
    public function testOffsetUnset()
    {
        $this->args['test'] = 'pass';
        $this->args->offsetUnset('test');
        $this->assertArrayNotHasKey('test', $this->args->get());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::merge
     */
    public function testMerge()
    {
        $this->args->merge(['test' => 'pass']);
        $this->assertArrayHasKey('test', $this->args->get());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::current
     */
    public function testCurrent()
    {
        $this->args[] = 'test 1';
        $this->assertEquals('test 1', $this->args->current());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::next
     */
    public function testNext()
    {
        $this->args['a'] = 'a';
        $this->args['b'] = 'b';
        $this->args['c'] = 'c';
        foreach ($this->args as $key => $arg) {
            $this->assertEquals($key, $arg);
        }
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::key
     */
    public function testKey()
    {
        $this->args['a'] = 'test';
        $this->assertEquals('a', $this->args->key());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::valid
     */
    public function testValid()
    {
        $this->args[] = 'test';
        $this->assertEquals(true, $this->args->valid());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::rewind
     */
    public function testRewind()
    {
        $this->args[] = 'test 1';
        $this->args[] = 'test 2';
        $this->args->next();
        $this->assertEquals(0, $this->args->rewind());
    }
}
