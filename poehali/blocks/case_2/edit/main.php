<?php
defined('AUTH') or die('Restricted access');

$arr = array(
	'case_add', 'cpanel', 'delete', 'insert', 'item_add', 'item_edit', 'item_insert', 'items_ordering', 'item_delete',
	'item_image_add', 'item_icon_add', 'item_text_update', 'item_image_delete', 'item_images_ordering', 'item_image_update', 
	'item_icon_svg_edit', 'item_icon_svg_update', 'item_icon_text_update', 'item_icons_ordering', 'item_icon_delete',
	'settings_edit', 'settings_update'
);

if (in_array($SITE->url_arr[3], $arr))
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/case_2/edit/'.$SITE->url_arr[3].'.php';
else
	include_once $_SERVER['DOCUMENT_ROOT'].'/404.php';

exit;
?>