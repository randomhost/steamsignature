<?php
/**
 * Steam Signature test script.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */

declare(strict_types=1);

use randomhost\Steam\API;
use randomhost\Steam\Signature;

require_once realpath(__DIR__.'/../../vendor').'/autoload.php';

ini_set('display_errors', '0');

// insert your Web API key here
$key = '';

// setup directories
$dataDirPath = realpath(__DIR__.'/../data');
$imageDir = $dataDirPath.'/images/';
$fontsDir = $dataDirPath.'/fonts/';
$cacheDir = sys_get_temp_dir().'/randomhost-steamsignature/';

try {
    // prepare cache directory

    // init a \Memcached instance for caching Steam user data
    $memcached = null;
    if (class_exists('\Memcached')) {
        $memcached = new \Memcached();
        $memcached->resetServerList();
        $memcached->addServer('localhost', 11211);
    }
    // init an API instance for talking to the Steam Web API
    $api = new API($key, $memcached);

    // process GET parameters
    $requiredParams = ['id', 'action'];
    foreach ($requiredParams as $param) {
        if (empty($_GET[$param])) {
            throw new \InvalidArgumentException(
                "Missing required request parameter \"{$param}\""
            );
        }
    }

    $steamId = trim($_GET['id']);
    $action = trim($_GET['action']);

    // resolve and redirect vanity URL calls
    if (!ctype_digit($steamId)) {
        $caching = $api->getMemcachedUsage();
        $api->setMemcachedUsage(false);
        $steamId = $api->resolveVanityUrl($steamId);
        $api->setMemcachedUsage($caching);

        $params = $_GET;
        $params['id'] = $steamId;

        if (empty($params['rewrite'])) {
            $params = http_build_query($params);
            $url = sprintf(
                'http%s://%s%s?%s',
                (!empty($_SERVER['HTTPS'])) ? 's' : '',
                $_SERVER['HTTP_HOST'],
                $_SERVER['SCRIPT_NAME'],
                $params
            );
        } else {
            switch ($action) {
                case 'go':
                    $params = $steamId.'/go';

                    break;

                case 'img':
                default:
                    $params = $steamId.'.png';
            }

            $url = sprintf(
                'http%s://%s%s/profilesig/%s',
                (!empty($_SERVER['HTTPS'])) ? 's' : '',
                $_SERVER['HTTP_HOST'],
                dirname($_SERVER['SCRIPT_NAME']),
                $params
            );
        }
        header('Location: '.$url, true, 303);

        exit;
    }

    // handle signature
    $signature = new Signature($api, $steamId, $imageDir, $fontsDir, $cacheDir);

    switch ($action) {
        case 'go':
            header('Location: '.$signature->getLinkTarget(), true, 303);

            exit;

        case 'img':
        default:
            $signature->render();

            break;
    }
} catch (\InvalidArgumentException $e) {
    http_response_code(400);
    if (!headers_sent()) {
        header('Retry-After: 120');
        header('Connection: Close');
        header('Content-Type: text/plain');
        echo '400 Bad Request';
    }
} catch (\Exception $e) {
    http_response_code(503);
    if (!headers_sent()) {
        header('Retry-After: 120');
        header('Connection: Close');
        header('Content-Type: text/plain');
        echo '503 Bad Request';
    }
}
