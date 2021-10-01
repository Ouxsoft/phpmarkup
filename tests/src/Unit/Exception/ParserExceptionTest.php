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

use Ouxsoft\PHPMarkup\Exception\Exception;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * @covers \Ouxsoft\PHPMarkup\Exception\Exception::__construct
     * @covers \Ouxsoft\PHPMarkup\Exception\Exception::getLog
     */
    public function test__construct()
    {
        $exception = new Exception('test');
        $this->assertIsString($exception->getLog());
    }
}
