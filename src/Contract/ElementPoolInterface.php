<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\PHPMarkup\Contract;

use Ouxsoft\PHPMarkup\Element\AbstractElement;
use ArrayIterator;
use Iterator;

/**
 * Interface ElementPoolInterface
 * @package Ouxsoft\PHPMarkup\Contract
 */
interface ElementPoolInterface
{
    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator;

    /**
     * @param string|null $element_id
     * @return AbstractElement|null
     */
    public function getById(?string $element_id = null): ?AbstractElement;

    /**
     * @param string $element_id
     * @return array
     */
    public function getPropertiesById(string $element_id): array;

    /**
     * @param AbstractElement $element
     */
    public function add(AbstractElement &$element): void;

    /**
     * @param string $routine
     */
    public function callRoutine(string $routine): void;
}
