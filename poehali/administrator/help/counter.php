<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Код счетчика';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);

$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Код счетчика</h1>'.
	'<div class="help_titles_wrap">'.	
		'<div class="help_titles_group"><h2 class="help_h2">Назначение</h2>'.
		'<div>Код счетчика собирает статистику посещений сайта по каждой странице. С помощью счетчика Вы можете отследить какие страницы пользуются популярностью, посмотреть время проведенное на сайте, карту кликов, провести анализ вашего бизнеса и многое другое.</div>'.	
		'</div>'.
		'<div class="help_titles_group"><h2 class="help_h2">Как вставить код счетчика</h2>'.
		'<div>Откройте настройки сайта, в поле "Код в header (метрика, метатеги):" вставьте код вашего счетчика.</div>'.			
		'</div>'.
	'</div>';
	
