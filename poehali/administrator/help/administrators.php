<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Админы сайта';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);

$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Админы сайта</h1>'.
	'<div class="help_titles_wrap">'.	
		'<div class="help_titles_group"><h2 class="help_h2">Назначение</h2>'.
		'<div>В данном разделе Вы можете добавить администраторов для управления сайтом, их может быть несколько.</div>'.	
		'</div>'.
		'<div class="help_titles_group"><h2 class="help_h2">Функционал</h2>'.
		'<div><ol>'.
			'<li>Задать логин</li>'.
			'<li>Задать пароль</li>'.
			'<li>Вставить описание, например личные данные администратора</li>'.
			'<li>Включить/отключить</li>'.
			'<li>Удалить администратора</li>'.
		'</ol></div>'.	
		'</div>'.
		'<div class="help_titles_group"><h2 class="help_h2">Как добавить администратора</h2>'.
		'<div><ol>'.
			'<li>Перейдите в раздел админы</li>'.
			'<li>Кнопку "Добавить пользователя"</li>'.
			'<li>Заполните обязательные поля "Логин" и "Пароль"</li>'.			
		'</ol></div>'.	
		'</div>'.
	'</div>';
	
