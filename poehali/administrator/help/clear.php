<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Очистить данные';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);

$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Очистить данные</h1>'.
	'<div class="help_titles_wrap">'.	
		'<div class="help_titles_group"><h2 class="help_h2">Назначение</h2>'.
		'<div>С помощью данной команды можно очистить весь сайт (удалить все страницы и разделы).</div>'.	
		'</div>'.
	'</div>';
	
