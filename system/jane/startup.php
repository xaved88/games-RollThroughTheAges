<?php

define('APP_CONFIG_DIR', APP_ROOT_DIR . 'config/');
define('APP_DATA_DIR', APP_ROOT_DIR . 'data/');
define('APP_FUNCTIONAL_TESTS_DIR', APP_ROOT_DIR . 'tests/functional/');
define('APP_INCLUDES_DIR', APP_ROOT_DIR . 'includes/');
define('APP_SERVICE_DIR', APP_ROOT_DIR . 'services/');
define('APP_SYSTEM_DIR', APP_ROOT_DIR . 'system/');
define('APP_SERVICE_NAMESPACE', 'Service');
define('APP_VENDOR_DIR', APP_ROOT_DIR . 'vendor/');

require APP_SYSTEM_DIR . 'jane/jane.php';

use Jane\Jane;

$jane = new Jane();