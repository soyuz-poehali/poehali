<?php
defined('AUTH') or die('Restricted access');

$arr = array('cpanel', 'delete', 'insert', 'image_update', 'settings_edit', 'settings_update', 'text_update');

if (in_array($SITE->url_arr[3], $arr))
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/scrolling_vertical/edit/'.$SITE->url_arr[3].'.php';
else
	include_once $_SERVER['DOCUMENT_ROOT'].'/404.php';

exit;
?>