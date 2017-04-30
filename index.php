<?php

define('APP_ROOT_DIR', getcwd() . '/');
define('APP_INCLUDES_DIR', APP_ROOT_DIR . 'includes/');
define('APP_SYSTEM_DIR', APP_ROOT_DIR . 'system/');
define('APP_CONFIG_DIR', APP_ROOT_DIR . 'config/');
define('APP_DATA_DIR', APP_ROOT_DIR . 'data/');
define('APP_VENDOR_DIR', APP_ROOT_DIR . 'vendor/');

use Jane\Jane;
use RTTA\Test\Test;


require 'system/jane/jane.php';
$jane = new Jane();

/**
 * @var Test $test
 */
$test = $jane->getService(Test::class);

echo "Config: " . $test->getConfigValue() . PHP_EOL;
echo "Data: " . print_r($test->getDataValue(),true) . PHP_EOL;
