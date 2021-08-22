<?php
// Закачиваем xml-файл версии установленной на сайте.
// К указанной версии прибавляем 0.01 - получаем последнюю версию обновления.
// Закачиваем файла обновления из соответствующей папки. 
// Подключаем этот файл. Этот файл вносит обновления.
// Удаляем 'administrator/upgrade/export_latest.xml' (загруженный файл для сравнения)
// Перезагружаем страницу

defined('AUTH') or die('Restricted access');

include("administrator/upgrade/mail_support.php");	// Подключаем файл отправки ошибок в тех. поддержку.

$SITE->content =
	'<h1>Установка обновления</h1>'.
	'<div>&nbsp;</div>';
	
// Загрузка XML-файла версии системы управления, установленной на сайте.
$xml_version = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/templates/version.xml');

if ($xml_version)  {
	// версия системы управления сайтом
	$version = $xml_version->cmsversion;
	$version = (real)$version;
}	

// --- Определяем номер следующей версии, которую необходимо скачать и установить ---
// К указанной версии прибавляем 0.01 - получаем последнюю версию обновления.
$next_version = $version + 0.01;
$next_version = (string)$next_version;
$next_version = str_replace('.','_',$next_version);


// ------- Скачиваем zip - файлы обновления -------
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/upgrade.zip')) {  // проверка существования старого файла upgrade.zip
	unlink($_SERVER['DOCUMENT_ROOT'].'/temp/upgrade.zip');  // удаляем upgrade.zip
}

$upgrade_files_zip_url = $latest_version_url.$next_version.'/upgrade.zip';

// Проверка существования версии на удалённом хосте - читаем заголовки ответа сервера
$headers_upgrade_files_zip_url = @get_headers($upgrade_files_zip_url);
// print_r ($headers);
// echo $headers[0];

// --- Проверяем, есть ли в заголовке 200 (файл существует) ---
if (strpos($headers_upgrade_files_zip_url[0],'200')) {
	$get_file = file_get_contents($upgrade_files_zip_url);
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/temp/upgrade.zip', $get_file);
	
	$SITE->content .= 'Файлы обновления скопированы. <br/>';
	
	// создаём архив
	$zip = new ZipArchive();
	
	// если zip-архив удалось открыть	
	if ($zip->open($_SERVER['DOCUMENT_ROOT'].'/temp/upgrade.zip') === true) {
		$SITE->content .= 'Обновление: <br/>';
		
		// --- Файл управлением обновления ---
		// Файл управления обновления для скачивания
		$next_version_url = $latest_version_url.$next_version.'/upgrade.upg';	
		
		// Проверка существования версии на удалённом хосте - читаем заголовки ответа сервера
		$headers = @get_headers($next_version_url);
		// print_r ($headers);
		// echo $headers[0];
		
		// Проверяем, есть ли в заголовке 200 (файл существует)
		if (strpos($headers[0],'200')) {
			$get_file = file_get_contents($next_version_url);
			file_put_contents($_SERVER['DOCUMENT_ROOT'].'/temp/upgrade_verion.php', $get_file);
			
			include $_SERVER['DOCUMENT_ROOT'].'/temp/upgrade_verion.php';
		} else {
			$SITE->content .=
			'<div class="margin-left-right-10">'.
				'<h4 class="red">Файл версии не найден</h4>'.			
			'</div>';
			
			// Отправляем сообщение об ошибке в службу тех. поддержки
			$error = '<p>Сайт: '.$SITE->domain.'</p><p>Файл версии обновления '.$next_version_url.' не найден</p>'; 
			mail_support($error);	
		}
				
		// удаляем export_latest.xml
		unlink($_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/export_latest.xml');
			
		// удаляем 'upgrade_verion.php'
		unlink($_SERVER['DOCUMENT_ROOT'].'/temp/upgrade_verion.php');	
		
		//закрытие архива
		$zip->close();			
	} else {
		$SITE->content .= 'Файл архива не удалось открыть. <br/>';
		
		// отправляем сообщение об ошибке в службу тех. поддержки
		$error = '<p>Сайт: '.$SITE->domain.'</p><p>Файл архива не удалось открыть.</p>'; 
		mail_support($error);			
	}			
} else {  // конец действия "если есть zip - архив"	
	$SITE->content .= '<div class="red">Файлы обновления не найдены! </div><br/>';		
}



// Загрузка XML-файла версии системы управления, установленной на сайте.
$xml_version = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/templates/version.xml');

if ($xml_version) {
	$version = $xml_version->cmsversion;  // Версия системы управления сайтом
	$version = (real)$version;	// Переводим в цифровой формат
}	

// --- Загрузка XML-файла последней версии системы управления с удалённого сервера. ---

// URL файла на сервере
$xml_url = $latest_version_url.'latest_version.xml';

// Закачка файла XML
$xml_latest = simplexml_load_file($xml_url);

if ($xml_latest) {	
	// последняя версия системы управления сайтом
	$latest = $xml_latest->cmsversion;
	$latest =(real)$latest;
}	

// проверка: установлена ли последняя версия сайта
if ($version >= $latest) {
	$SITE->content .= 
		'<div>&nbsp;</div>'.
		'<div class="margin-left-right-10">'.
			'<div>Текущая версия сайта <span class="red"><b>'.$version.'</b></span></div>'.
			'<div>Текущая версия обновления <span class="red"><b>'.$latest.'</b></span></div>'.
			'<h4 class="green">Обновление не требуется, у вас установлена последняя версия сайта</h4>'.			
		'</div>';		
	
} else {
	$SITE->content .= 
		'<div>&nbsp;</div>'.
		'<div class="margin-left-right-10">'.
			'<div><span class="red"><b>Требуется следующий шаг установки обновления</b></span></div>'.
			'<div>&nbsp;</div>'.
			'<div>Текущая версия сайта <span class="red"><b>'.$version.'</b></span></div>'.
			'<div>Текущая версия обновления <span class="red"><b>'.$latest.'</b></span></div>'.
			'<h4><a class="red" href="/admin/upgrade/upgrade/"><img border="0" src="/administrator/templates/images/setup_red.png" width="306" height="83"  align="middle"/></a></h4>'.		
			'<div>Для установки обновления потребуется некоторое время. Не закрывайте страницу.</div>'.
		'</div>	';		
}

?>