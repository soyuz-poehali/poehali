<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Настройки сайта';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);

$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Настройки сайта</h1>'.
	'<div class="help_titles_wrap">'.	
		'<div class="help_titles_group"><h2 class="help_h2">Назначение</h2>'.
		'<div>Настройки сайта предназначены для указания глобальных настроек сайта. Включения/отключения сайта, указание адреса электронной почты для приема заявок, метатегов поисковиков и кодов статистики/аналитики.</div>'.	
		'</div>'.
		'<div class="help_titles_group"><h2 class="help_h2">Возможности настроек</h2>'.
		'<div><ol>'.
			'<li>Включение/отключение сайта</li>'.
			'<li>Указание адреса электронной почты для приема заявок</li>'.
			'<li>Вставка метатегов для поисковиков</li>'.
			'<li>Вставка кодов статистики/аналитики.</li>'.
			'<li>Очистка данных сайта</li>'.
		'</ol></div>'.			
		'</div>'.
	'</div>';
	
