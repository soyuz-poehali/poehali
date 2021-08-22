<?php
defined('AUTH') or die('Restricted access');

$arr = array('cpanel', 'delete', 'help', 'insert', 'items', 'item_edit', 'item_insert', 'item_update', 'item_delete', 'items_ordering', 'settings_edit', 'settings_update');

if (in_array($SITE->url_arr[3], $arr))
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/virtual_tour/edit/'.$SITE->url_arr[3].'.php';
else
	include_once $_SERVER['DOCUMENT_ROOT'].'/404.php';

exit;

?>