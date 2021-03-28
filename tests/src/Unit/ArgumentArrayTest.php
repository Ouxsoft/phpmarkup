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
use PHPUnit\Framework\TestCase;

class ArgumentArrayTest extends TestCase
{
    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::count
     */
    public function testCount()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetSet
     */
    public function testOffsetSet()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);

        // check to make sure only one item exists
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);


        // check to see if it turns key into an array
        $args->offsetSet('1', 'test_2');
        $this->assertCount(1, $args);
        $this->assertIsArray($args['1']);

        // check to make sure duplicated item isn't added to array
        $args->offsetSet('1', 'test_2');
        $this->assertCount(1, $args);


        // check if item added to array
        $args->offsetSet('1', 'test3');
        $this->assertCount(1, $args);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetExists
     */
    public function testOffsetExists()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $bool = $args->offsetExists(1);
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::get
     */
    public function testGet()
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';
        $this->assertArrayHasKey('test', $args->get());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetGet
     */
    public function testOffsetGet()
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';
        $this->assertStringContainsString($args->offsetGet('test'), 'pass');
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::offsetUnset
     */
    public function testOffsetUnset()
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';
        $args->offsetUnset('test');
        $this->assertArrayNotHasKey('test', $args->get());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::merge
     */
    public function testMerge()
    {
        $args = new ArgumentArray();
        $args->merge(['test' => 'pass']);
        $this->assertArrayHasKey('test', $args->get());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::current
     */
    public function testCurrent()
    {
        $args = new ArgumentArray();
        $args[] = 'test 1';
        $this->assertEquals('test 1', $args->current());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::next
     */
    public function testNext()
    {
        $args = new ArgumentArray();
        $args['a'] = 'a';
        $args['b'] = 'b';
        $args['c'] = 'c';
        foreach ($args as $key => $arg) {
            $this->assertEquals($key, $arg);
        }
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::key
     */
    public function testKey()
    {
        $args = new ArgumentArray();
        $args['a'] = 'test';
        $this->assertEquals('a', $args->key());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::valid
     */
    public function testValid()
    {
        $args = new ArgumentArray();
        $args[] = 'test';
        $this->assertEquals(true, $args->valid());
    }

    /**
     * @covers \Ouxsoft\PHPMarkup\ArgumentArray::rewind
     */
    public function testRewind()
    {
        $args = new ArgumentArray();
        $args[] = 'test 1';
        $args[] = 'test 2';
        $args->next();
        $this->assertEquals(0, $args->rewind());
    }
}
