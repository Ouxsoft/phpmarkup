<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Tests\Resource\Element;

use Ouxsoft\PHPMarkup\Element\AbstractElement as AbstractElement;

/**
 * Class HelloWorld
 *
 * Hyperlink simple HelloWorld Element example
 *
 * <widget name="HelloWorld"/>
 *
 * @package Ouxsoft\PHPMarkup\Elements\Widgets
 */
class HelloWorld extends AbstractElement
{
    /**
     * Prints Hello, World
     *
     * @return mixed|string
     */
    public function onRender()
    {
        return 'Hello, World';
    }
}
