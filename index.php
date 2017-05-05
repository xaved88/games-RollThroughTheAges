<?php

define('APP_ROOT_DIR', getcwd() . '/');
define('APP_PROJECT_NAMESPACE','RTTA');
define('APP_FUNCTIONAL_TESTS_NAMESPACE','TestsFunctional');

use Jane\Jane;

require 'system/jane/startup.php';

/**
 * @var Jane $jane
 */

$path = $_GET['path'];
$params = $_POST['params'] ?? [];
$response = $jane->callService($path,$params);
echo $response;
