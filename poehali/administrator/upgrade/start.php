<?php
defined('AUTH') or die('Restricted access');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr[''] = 'Обновления';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);

// загрузка XML-файла версии системы управления, установленной на сайте.
$xmlversion = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/templates/version.xml');

if ($xmlversion) {	
	$version = $xmlversion->cmsversion;
	$version = (real)$version;  // переводим в цифровой формат
}

// ------- Загрузка XML-файла последней версии системы управления с удалённого сервера. -------
$xml_url = $latest_version_url.'latest_version.xml';  // URL файла на сервере

$xml_latest = simplexml_load_file($xml_url);

if ($xml_latest) {	
	$latest = $xml_latest->cmsversion;	// Последняя версия системы управления сайтом
	$latest =(real)$latest;
}


$SITE->content = 
	$breadcrumbs.
	'<h1>Обновления</h1>';

// Проверка: установлена ли последняя версия сайта
if ($version >= $latest) {
	$SITE->content .=
		'<div id="main-top"><img border="0" src="/administrator/templates/images/upgrade25.png" width="25" height="25"  align="middle"/>&nbsp;&nbsp;Обновление не требуется.</div>'.
		'<div>&nbsp;</div>'.
		'<div class="margin-left-right-10">'.
			'<div>Текущая версия сайта <span class="red"><b>'.$version.'</b></span></div>'.
			'<div>Текущая версия обновления <span class="red"><b>'.$latest.'</b></span></div>'.
			'<h4 class="green">Обновление не требуется, у вас установлена последняя версия сайта</h4>'.			
		'</div>';		
} else {
	$SITE->content .=
		'<div id="main-top"><img border="0" src="/administrator/templates/images/upgrade25.png" width="25" height="25"  align="middle"/>&nbsp;&nbsp;Установка обновления сайта</div>'.
		'<div>&nbsp;</div>'.
		'<div class="margin-left-right-10">'.
			'<div>Текущая версия сайта <span class="red"><b>'.$version.'</b></span></div>'.
			'<div>Текущая версия обновления <span class="red"><b>'.$latest.'</b></span></div>'.
			'<h4><a class="red" href="/admin/upgrade/upgrade"><img border="0" src="/administrator/templates/images/setup_red.png" width="306" height="83"  align="middle"/></a></h4>'.			
			'<div>Для установки обновления потребуется некоторое время. Не закрывайте страницу.</div>'.
		'</div>';		
}




?>