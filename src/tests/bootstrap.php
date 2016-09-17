<?php
/**
 * Helper for setting up tests.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-image.random-host.com
 */

if (!defined('APP_TOPDIR')) {
    define('APP_TOPDIR', realpath(__DIR__ . '/../php'));
    define('VENDOR', realpath(__DIR__ . '/../../vendor'));
    define('APP_TESTDIR', realpath(__DIR__ . '/unit-tests/php'));
    define('APP_LIBDIR', realpath(VENDOR . 'php'));
    define('APP_DATADIR', realpath(__DIR__ . '/../data'));

    define('PHPSPEC_BASE', VENDOR . '/phpspec');
    define('BEHAT_BASE', VENDOR . '/behat');
    define('SYMFONY', VENDOR . '/symfony');
}

require_once VENDOR . '/autoload.php';
