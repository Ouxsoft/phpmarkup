<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Test\Unit\Exception;

use Ouxsoft\PHPMarkup\Exception\ParserException;
use PHPUnit\Framework\TestCase;

class ParserExceptionTest extends TestCase
{
    /**
     * @covers \Ouxsoft\PHPMarkup\Exception\ParserException::__construct
     * @covers \Ouxsoft\PHPMarkup\Exception\ParserException::getLog
     */
    public function test__construct()
    {
        $exception = new ParserException('test');
        $this->assertIsString($exception->getLog());
    }
}
