<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ouxsoft\PHPMarkup\Exception;

use RuntimeException;

/**
 * Class Exception
 * @package Ouxsoft\PHPMarkup\Exception
 */
class ParserException extends RuntimeException
{
    private $log;

    /**
     * Exception constructor.
     *
     * @param string|null $log
     */
    public function __construct(string $log = null)
    {
        parent::__construct();

        $this->log = $log;
    }

    /**
     * Returns log
     *
     * @return string|null
     */
    public function getLog(): ?string
    {
        return $this->log;
    }
}
