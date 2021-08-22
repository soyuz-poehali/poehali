<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/insert.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/settings_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>