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

/**
 * Interface DocumentInterface
 * @package Ouxsoft\PHPMarkup\Contract
 */
interface DocumentInterface
{
    /**
     * DocumentInterface constructor.
     */
    public function __construct();

    /**
     * @param string $source
     * @return bool
     */
    public function loadSource(string $source): bool;
}
