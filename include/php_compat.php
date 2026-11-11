<?php
/**
 * PHP 7.4 / 8.x compatibility shims for legacy shop code.
 * Safe no-op when native functions already exist.
 */
if (defined('PKSHOP_PHP_COMPAT_LOADED')) {
	return;
}
define('PKSHOP_PHP_COMPAT_LOADED', 1);

/* Production-safe defaults on PHP 8.x shared hosting */
if (!ini_get('display_errors')) {
	@ini_set('display_errors', '0');
}
@ini_set('log_errors', '1');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);

if (!function_exists('each')) {
	function each(&$arr) {
		if (!is_array($arr) && !($arr instanceof ArrayAccess)) {
			return false;
		}
		$key = key($arr);
		if ($key === null) {
			return false;
		}
		$val = current($arr);
		next($arr);
		return array(1 => $val, 'value' => $val, 0 => $key, 'key' => $key);
	}
}

if (!function_exists('split')) {
	function split($pattern, $string, $limit = -1) {
		$delim = chr(1);
		$quoted = $delim . str_replace($delim, '\\' . $delim, $pattern) . $delim;
		$parts = @preg_split($quoted, (string)$string, $limit);
		if ($parts === false) {
			return explode($pattern, (string)$string, $limit < 0 ? PHP_INT_MAX : $limit);
		}
		return $parts;
	}
}

if (!function_exists('ereg')) {
	function ereg($pattern, $string, &$regs = null) {
		$p = '/' . str_replace('/', '\/', (string)$pattern) . '/';
		$m = array();
		$ok = @preg_match($p, (string)$string, $m);
		if ($ok && func_num_args() > 2) {
			$regs = $m;
		}
		return $ok ? 1 : false;
	}
}

if (!function_exists('eregi')) {
	function eregi($pattern, $string, &$regs = null) {
		$p = '/' . str_replace('/', '\/', (string)$pattern) . '/i';
		$m = array();
		$ok = @preg_match($p, (string)$string, $m);
		if ($ok && func_num_args() > 2) {
			$regs = $m;
		}
		return $ok ? 1 : false;
	}
}

if (!function_exists('ereg_replace')) {
	function ereg_replace($pattern, $replacement, $string) {
		$p = '/' . str_replace('/', '\/', (string)$pattern) . '/';
		return preg_replace($p, $replacement, (string)$string);
	}
}

if (!function_exists('eregi_replace')) {
	function eregi_replace($pattern, $replacement, $string) {
		$p = '/' . str_replace('/', '\/', (string)$pattern) . '/i';
		return preg_replace($p, $replacement, (string)$string);
	}
}

if (!function_exists('strftime')) {
	function strftime($format, $timestamp = null) {
		if ($timestamp === null) {
			$timestamp = time();
		}
		$map = array(
			'%Y' => 'Y', '%m' => 'm', '%d' => 'd', '%H' => 'H', '%M' => 'i', '%S' => 's',
			'%y' => 'y', '%I' => 'h', '%p' => 'A', '%a' => 'D', '%A' => 'l',
			'%b' => 'M', '%B' => 'F', '%w' => 'w', '%j' => 'z', '%U' => 'W',
			'%e' => 'j', '%T' => 'H:i:s', '%D' => 'm/d/y', '%R' => 'H:i', '%F' => 'Y-m-d',
			'%%' => '%',
		);
		$php = strtr((string)$format, $map);
		return date($php, (int)$timestamp);
	}
}

if (!function_exists('create_function')) {
	function create_function($args, $code) {
		static $n = 0;
		$n++;
		$name = 'pkshop_lambda_' . $n . '_' . md5($args . "\0" . $code);
		if (!function_exists($name)) {
			eval('function ' . $name . '(' . $args . ') { ' . $code . ' }');
		}
		return $name;
	}
}

if (!function_exists('get_magic_quotes_gpc')) {
	function get_magic_quotes_gpc() {
		return 0;
	}
}

if (!function_exists('get_magic_quotes_runtime')) {
	function get_magic_quotes_runtime() {
		return 0;
	}
}

if (!function_exists('set_magic_quotes_runtime')) {
	function set_magic_quotes_runtime($new_setting) {
		return true;
	}
}

/* ---- mysql_* → mysqli shim (PHP 7+/8) ---- */
if (!function_exists('mysql_connect') && function_exists('mysqli_connect')) {
	$GLOBALS['__pk_mysql_links'] = array();
	$GLOBALS['__pk_mysql_default'] = null;

	function __pk_mysql_link($link_identifier = null) {
		if ($link_identifier instanceof mysqli) {
			return $link_identifier;
		}
		if ($link_identifier !== null && isset($GLOBALS['__pk_mysql_links'][$link_identifier])) {
			return $GLOBALS['__pk_mysql_links'][$link_identifier];
		}
		return $GLOBALS['__pk_mysql_default'];
	}

	function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0) {
		$link = @mysqli_connect($server, $username, $password);
		if (!$link) {
			return false;
		}
		$id = (string)spl_object_id($link);
		$GLOBALS['__pk_mysql_links'][$id] = $link;
		$GLOBALS['__pk_mysql_default'] = $link;
		return $link;
	}

	function mysql_pconnect($server = null, $username = null, $password = null, $client_flags = 0) {
		return mysql_connect($server, $username, $password, false, $client_flags);
	}

	function mysql_select_db($database_name, $link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		if (!$link) {
			return false;
		}
		return mysqli_select_db($link, $database_name);
	}

	function mysql_query($query, $link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		if (!$link) {
			return false;
		}
		return mysqli_query($link, $query);
	}

	function mysql_real_escape_string($unescaped_string, $link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		if ($link) {
			return mysqli_real_escape_string($link, $unescaped_string);
		}
		return addslashes($unescaped_string);
	}

	function mysql_escape_string($unescaped_string) {
		return mysql_real_escape_string($unescaped_string);
	}

	function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
		if ($result_type === 1 /* MYSQL_ASSOC legacy */) {
			$result_type = MYSQLI_ASSOC;
		} elseif ($result_type === 2 /* MYSQL_NUM */) {
			$result_type = MYSQLI_NUM;
		} elseif ($result_type === 3 /* MYSQL_BOTH */) {
			$result_type = MYSQLI_BOTH;
		}
		return mysqli_fetch_array($result, $result_type);
	}

	function mysql_fetch_assoc($result) {
		return mysqli_fetch_assoc($result);
	}

	function mysql_fetch_row($result) {
		return mysqli_fetch_row($result);
	}

	function mysql_fetch_object($result, $class_name = 'stdClass', $params = array()) {
		if ($params) {
			return mysqli_fetch_object($result, $class_name, $params);
		}
		return mysqli_fetch_object($result, $class_name);
	}

	function mysql_num_rows($result) {
		return mysqli_num_rows($result);
	}

	function mysql_affected_rows($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_affected_rows($link) : -1;
	}

	function mysql_insert_id($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_insert_id($link) : 0;
	}

	function mysql_error($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_error($link) : mysqli_connect_error();
	}

	function mysql_errno($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_errno($link) : mysqli_connect_errno();
	}

	function mysql_close($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		if (!$link) {
			return false;
		}
		$id = (string)spl_object_id($link);
		unset($GLOBALS['__pk_mysql_links'][$id]);
		if ($GLOBALS['__pk_mysql_default'] === $link) {
			$GLOBALS['__pk_mysql_default'] = null;
		}
		return mysqli_close($link);
	}

	function mysql_free_result($result) {
		mysqli_free_result($result);
		return true;
	}

	function mysql_result($result, $row, $field = 0) {
		if (!mysqli_data_seek($result, $row)) {
			return false;
		}
		$arr = mysqli_fetch_array($result, MYSQLI_BOTH);
		if (!$arr) {
			return false;
		}
		return isset($arr[$field]) ? $arr[$field] : false;
	}

	function mysql_num_fields($result) {
		return mysqli_num_fields($result);
	}

	function mysql_data_seek($result, $row_number) {
		return mysqli_data_seek($result, $row_number);
	}

	function mysql_set_charset($charset, $link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_set_charset($link, $charset) : false;
	}

	function mysql_get_server_info($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_get_server_info($link) : '';
	}

	function mysql_ping($link_identifier = null) {
		$link = __pk_mysql_link($link_identifier);
		return $link ? mysqli_ping($link) : false;
	}

	if (!defined('MYSQL_ASSOC')) {
		define('MYSQL_ASSOC', MYSQLI_ASSOC);
	}
	if (!defined('MYSQL_NUM')) {
		define('MYSQL_NUM', MYSQLI_NUM);
	}
	if (!defined('MYSQL_BOTH')) {
		define('MYSQL_BOTH', MYSQLI_BOTH);
	}
}
