<?php

/**
 * @file
 * The Front Controller.
 */

declare(strict_types = 1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use ZenFramework\Core\ZenFrameworkKernel;

$autoloader = require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new ZenFrameworkKernel('prod', $autoloader);

// @todo Move into stack.
$kernel = new HttpCache(
  $kernel,
  new Store(__DIR__ . '/../cache')
);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
