<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/administrator/help/template/style.css');

switch ($SITE->url_arr[2]) {
	case 'principle':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/principle.php';
		break;
		
	case 'blocks':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/main-blocks.php';
		break;		

	case 'ckeditor':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/plugins/ckeditor_inline/help/help.php';
		break;		
	
	case 'catalogs':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/catalogs.php';
		break;
		
	case 'shop':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/shop.php';
		break;	

	case 'pages':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/pages.php';
		break;

	case 'com':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/com.php';
		break;

	case 'settings':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/settings.php';
		break;
		
	case 'counter':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/counter.php';
		break;
		
	case 'favicon':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/favicon.php';
		break;			

	case 'administrators':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/administrators.php';
		break;

	case 'clear':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/clear.php';
		break;

	case 'menu':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/menu.php';
		break;

	case 'edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/edit.php';
		break;

	case 'menu':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/menu.php';
		break;
		
	case 'visual':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/visual.php';
		break;
	
	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/mainpage.php';
		break;
}

?>