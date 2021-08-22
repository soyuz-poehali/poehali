<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr[''] = 'Помощь';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1>Помощь</h1>'.
	'<div class="help_titles_wrap">'.
	'<a href="/admin/help/principle"><h2 class="help_h2">Принцип построения сайта</h2></a>'.
	'<a href="/admin/help/blocks"><h2 class="help_h2">Блоки</h2></a>'.	
	'<a href="/admin/help/pages"><h2 class="help_h2">Страницы</h2></a>'.
	'<a href="/admin/help/menu"><h2 class="help_h2">Меню</h2></a>'.
	'<div class="help_titles_group"><h2 class="help_h2">Компоненты</h2>'.	
	'<a href="/admin/help/catalogs"><h3 class="help_h3">Каталог</h3></a>'.
	'<a href="/admin/help/shop"><h3 class="help_h3">Интернет-магазин</h3></a></div>'.
	//'<a href="/admin/help/news"><h3 class="help_h3">Новости</h3></a>'.
	'<div class="help_titles_group"><h2 class="help_h2">Плагины</h2>'.	
	'<a href="/admin/help/ckeditor"><h3 class="help_h3">CKEditor</h3></a></div>'.
	'<div class="help_titles_group"><a href="/admin/help/settings"><h2 class="help_h2">Настройки сайта</h2></a>'.
	'<a href="/admin/help/counter"><h3 class="help_h3">Код счетчика</h3></a>'.
	'<h3 class="help_h3">Favicon</h3>'.
	'<a href="/admin/help/clear"><h3 class="help_h3">Очистить данные</h3></a></div>'.	
	'<div class="help_titles_group"><h2 class="help_h2">Администрирование сайта</h2>'.	
	'<a href="/admin/help/administrators"><h3 class="help_h3">Админы</h3></a>'.
	'<a href="/admin/help/visual"><h3 class="help_h3">Режим визуального редактирования</h3></a></div>'.	
	'</div>';
	
