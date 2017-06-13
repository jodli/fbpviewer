<?php

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Annotations\AnnotationRegistry;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
if (PHP_VERSION_ID < 70000) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$kernel = new AppKernel('prod', false);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
Request::setTrustedHeaderName(Request::HEADER_CLIENT_IP, 'X-PROXY-ORIGINAL-IP');
Request::setTrustedHeaderName(Request::HEADER_FORWARDED, null);
Request::setTrustedProxies(['10.0.0.0/8']);

//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
