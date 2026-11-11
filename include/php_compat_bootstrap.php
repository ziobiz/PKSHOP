<?php
/**
 * Directory auto_prepend entry: keep host security prepend, then load compat shims.
 */
$host_prepend = '/home/prepend/prepend.php';
if (is_readable($host_prepend)) {
	include_once $host_prepend;
}
require_once __DIR__ . '/php_compat.php';
