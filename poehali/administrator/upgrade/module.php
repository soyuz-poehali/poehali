<?php
// Выводит список модулей слева

defined('AUTH') or die('Restricted access');

function module_upgrade()
{
	global $latest_version_url;

	$xml_file = $_SERVER['DOCUMENT_ROOT'].'/templates/version.xml';

	$version = 0;
	$version_html = '-';

	if (is_file($xml_file)) {
		$xml_version = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/templates/version.xml');
		
		if ($xml_version) {	
			$version = $xml_version->cmsversion;  // Версия системы управления сайтом
			$version = (real)$version;
		}		
	}


	// ------- Загрузка XML-файла последней версии системы управления с удалённого сервера -------
    $xml_url = $latest_version_url.'latest_version.xml';  // URL файла на сервере
    $export_latest = $_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/export_latest.xml';	 // Имя файла для хранения xml на локальном сервере
	
	// Закачка файла XML
   	// Если файла не существует (не закачан) или он устарел (свыше 24 часов) - закачать!
	
	if (!file_exists($export_latest) || time() > (filemtime($export_latest) + 60*60*24)) {
		$get_xml_file = @file_get_contents($xml_url);

		if ($get_xml_file) 
			file_put_contents($export_latest, $get_xml_file);
	}

	$xml_latest = @simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/export_latest.xml');	
	if ($xml_latest) {
		$latest = $xml_latest->cmsversion;  // Последняя версия системы управления сайтом
		$latest = (real)$latest;
	}


	//$version = "1.0";
	//$latest = "1.0";
	// ======= Проверка версии ====================================================================
	if (isset($xml_latest->cmsversion)) {
		if ($version >= $latest) {
			$version_html =
				'<div class="header_ico_square">'.
					'<div class="header_version">'.$version.'</div>'.
					'<div class="header_ico_square_text">версия</div>'.
				'</div>';	
		}
		else {
			$version_html =
				'<a href="/admin/upgrade" target="_blank" class="header_ico_square new">'.
					'<svg><use xlink:href="/administrator/templates/images/sprite.svg#new"></use></svg>'.
					'<div class="header_ico_square_text">Обновл.</div>'.
				'</a>';	
		}

	} else {
		$version_html =
			'<div class="header_ico_square">'.
				'<span style="font-size:9px;">Обновление не найдено</span>'.
			'</div>';	
	}

	echo $version_html;
}

?>