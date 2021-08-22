<?php
defined('AUTH') or die('Restricted access');
$admin_help = true;

switch ($SITE->url_arr[3]) {
	case '':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/bloks.php';
		break;
		
	case 'text':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/help/help.php';
		break;		
		
	case 'image':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/help/help.php';
		break;
	
	case 'photogallery':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/help/help.php';
		break;
		
	case 'slider':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/help/help.php';
		break;
	
	case 'video':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/help/help.php';
		break;
	
	case 'form':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/help/help.php';
		break;
	
	case 'packages':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/help/help.php';
		break;
	
	case 'case':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/help/help.php';
		break;
	
	case 'case_2':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/case_2/edit/help/help.php';
		break;
	
	case 'site_portfolio':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/site_portfolio/edit/help/help.php';
		break;
	
	case 'scrolling_vertical':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/scrolling_vertical/edit/help/help.php';
		break;
	
	case 'icon':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/help/help.php';
		break;
	
	case 'mapsyandex':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/help/help.php';
		break;
	
	case 'contacts':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/help/help.php';
		break;
	
	case 'menu':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/help/help.php';
		break;
	
	case 'callback':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/callback/edit/help/help.php';
		break;
	
	case 'buttonup':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/buttonup/edit/help/help.php';
		break;
	
	case 'virtual_tour':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/virtual_tour/edit/help/help.php';
		break;
	
	case 'image_360':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/image_360/edit/help/help.php';
		break;
	
	case 'catalog':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/edit/help/help.php';
		break;
	
	case 'code':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/help/help.php';
		break;
	
	case 'php_code':
			include $_SERVER['DOCUMENT_ROOT'].'/blocks/php_code/edit/help/help.php';
		break;
	
	
	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/help/bloks.php';
		break;
}

?>