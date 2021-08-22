<?php
defined('AUTH') or die('Restricted access');

$arr = array('cpanel', 'delete', 'edit', 'help', 'insert', 'settings_edit', 'settings_update', 'update');

if (in_array($SITE->url_arr[3], $arr))
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/edit/'.$SITE->url_arr[3].'.php';
else
	include_once $_SERVER['DOCUMENT_ROOT'].'/404.php';

exit;
?>