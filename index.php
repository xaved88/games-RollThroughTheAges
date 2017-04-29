<?php

define('APP_ROOT_DIR', getcwd() . '/');
define('APP_INCLUDES_DIR', APP_ROOT_DIR . 'includes/');
define('APP_SYSTEM_DIR', APP_ROOT_DIR . 'system/');


use Jane\Jane;
use Test\Test;


require 'system/jane/jane.php';
$jane = new Jane();

/**
 * @var Test $test
 */
$test = $jane->getService(Test::class);

$test->test();