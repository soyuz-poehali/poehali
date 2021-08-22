<?php
defined('AUTH') or die('Restricted access');

$arr = array('add', 'delete', 'edit', 'insert', 'update');

if (in_array($SITE->url_arr[3], $arr)) {
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/crm/users/'.$SITE->url_arr[3].'/main.php';
} else {
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/crm/users/mainpage.php';	
}

?>