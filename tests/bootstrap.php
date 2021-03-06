<?php
/*
 * This file is part of the PHPMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// define common directories
define('ROOT_DIR', dirname(__DIR__, 1) . '/');
define('TEST_DIR', ROOT_DIR . 'tests/src/');
define('ASSET_DIR', ROOT_DIR . 'assets/');

require ROOT_DIR . 'vendor/autoload.php';

// set include path
set_include_path(ROOT_DIR);

// set time
date_default_timezone_set('UTC');

// ensure notices are caught by tests
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
