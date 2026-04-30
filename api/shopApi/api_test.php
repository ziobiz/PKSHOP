<?
//   error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );
	include_once( "../lib/basic_class.php");
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php");


    foreach ($_REQUEST as $key => $value) {
        $text=$text."&$key=$value";
    }
			$DB->insert("TEXT=:TEXT",array("TEXT"=>$text),"key","test");
			
?>