<?php


define('APP_ROOT_DIR', getcwd() . '/');
define('SERVICE_NAMESPACE','RTTA\Service');

use Jane\Jane;

require 'system/jane/startup.php';

/**
 * @var Jane $jane
 */


use RTTA\Test\Test;
/**
 * @var Test $test
 */

$path = $_GET['path'];
$params = $_POST['params'] ?? [];
$response = $jane->callService($path,$params);
echo $response;
