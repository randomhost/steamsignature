<?php
/**
 * Steam Signature test script
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://github.random-host.com/steamsignature/
 */
namespace randomhost\Steam;

require_once realpath(__DIR__ . '/../../vendor') . '/autoload.php';

// initialize parameters with default values
$steamId = '76561197963139525';
$action = 'img';

// insert your Web API key here
$key = '';

// setup directories
$dataDirPath = realpath(__DIR__ . '/../data');
$imageDir = $dataDirPath . '/images/';
$fontsDir = $dataDirPath . '/fonts/';
$cacheDir = sys_get_temp_dir() . '/randomhost-steamsignature/';

// prepare cache directory
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

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
if (!empty($_GET['id'])) {
    $steamId = trim($_GET['id']);
}
if (!empty($_GET['action'])) {
    $action = trim($_GET['action']);
}

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
            (!empty($_SERVER['SSL'])) ? 's' : '',
            $_SERVER['HTTP_HOST'],
            $_SERVER['SCRIPT_NAME'],
            $params
        );
    } else {
        if ($action === 'go') {
            $params = $steamId . '/go';
        } else {
            $params = $steamId . '.png';
        }
        $url = sprintf(
            'http%s://%s%s/profilesig/%s',
            (!empty($_SERVER['SSL'])) ? 's' : '',
            $_SERVER['HTTP_HOST'],
            dirname($_SERVER['SCRIPT_NAME']),
            $params
        );
    }
    header('Location: ' . $url, true, 303);
    exit;
}

// handle signature
$signature = new Signature($api, $steamId, $imageDir, $fontsDir, $cacheDir);
if ($signature instanceof Signature) {
    switch ($action) {
        case 'go':
            header('Location: ' . $signature->getLinkTarget(), true, 303);
            exit;
        case 'img':
        default:
            $signature->render();
            break;
    }
}
