<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Tests\Feature;

use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;
use Ouxsoft\PHPMarkup\Processor;
use Ouxsoft\PHPMarkup\Engine;
use PHPUnit\Framework\TestCase;

final class SecurityTest extends TestCase
{
    /**
     * @var Processor
     */
    private $processor;

    public function setUp(): void
    {
        $this->processor = ProcessorFactory::getInstance();
    }

    public function tearDown(): void
    {
        unset($this->processor);
    }


    public function testNoProcessFlag()
    {
        $this->processor->addElement([
            'name' => 'Bitwise',
            'xpath' => "//bitwise",
            'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\Bitwise'
        ]);

        $this->processor->addElement([
            'name' => 'HelloWolrd',
            'xpath' => "//helloworld[not(ancestor::*[@process='false'])]",
            'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
        ]);

        $this->processor->addRoutine([
            'method' => 'onRender',
            'description' => 'Execute while object is rendering',
            'execute' => 'RETURN_CALL'
        ]);

        $html = file_get_contents(TEST_DIR . 'Resource/inputs/security-test.html');

        $test_results = $this->processor->parseString($html);

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/security-test.html',
            $test_results
        );
    }

    public function testArgsRemoved()
    {
        $this->processor->addElement([
            'xpath' => "//helloworld[not(ancestor::*[@process='false'])]",
            'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
        ]);

        $this->processor->addRoutine([
            'method' => 'onRender',
            'execute' => 'RETURN_CALL'
        ]);
        $html = $this->processor->parseString('<html><helloworld><arg name="limit">1</arg></helloworld></html>');
        $tag = '<arg';
        $this->assertStringNotContainsString($tag, $html);
    }

    public function testElementIdRemoved()
    {
        $this->processor->addElement([
            'xpath' => "//helloworld[not(ancestor::*[@process='false'])]",
            'class_name' => 'Ouxsoft\PHPMarkup\Tests\Resource\Element\HelloWorld'
        ]);
        $this->processor->addRoutine([
            'method' => 'onRender',
            'execute' => 'RETURN_CALL'
        ]);
        $html = $this->processor->parseString('<html><helloworld><arg name="limit">1</arg></helloworld></html>');
        $attribute = Engine::INDEX_ATTRIBUTE;
        $this->assertStringNotContainsString($attribute, $html);
    }
}
