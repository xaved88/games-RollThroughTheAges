<?php

define('APP_CONFIG_DIR', APP_ROOT_DIR . 'config/');
define('APP_DATA_DIR', APP_ROOT_DIR . 'data/');
define('APP_FUNCTIONAL_TESTS_DIR', APP_ROOT_DIR . 'tests/functional/');
define('APP_INCLUDES_DIR', APP_ROOT_DIR . 'includes/');
define('APP_LOGS_DIR', APP_ROOT_DIR . 'logs/');
define('APP_SERVICE_DIR', APP_ROOT_DIR . 'services/');
define('APP_SYSTEM_DIR', APP_ROOT_DIR . 'system/');
define('APP_JANE_DIR', APP_SYSTEM_DIR . 'jane/');
define('APP_VENDOR_DIR', APP_ROOT_DIR . 'vendor/');

define('APP_JANE_NAMESPACE', 'Jane');
define('APP_SERVICE_NAMESPACE', 'Service');

/**
 * Dirty, I know, but easy for testing when xdebug isn't working properly.
 *
 * @param     $data
 * @param int $lineCount
 */
function llog($data, int $lineCount = 1)
{
    if (is_array($data) || is_object($data)) {
        $data = var_export($data, true);
    }

    if ($lineCount !== 0) {
        $lines = array_fill(0, abs($lineCount), PHP_EOL);
        $lines = implode('', $lines);
        if ($lineCount > 0) {
            $data .= $lines;
        } else {
            $data = $lines .= $data;
        }
    }

    file_put_contents(APP_LOGS_DIR . "logan.log", $data, FILE_APPEND);
}

require APP_JANE_DIR . 'Jane.php';

use Jane\Jane;

$jane = new Jane();