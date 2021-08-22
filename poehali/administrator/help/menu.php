<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Меню';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Меню</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
		'<div class="help_titles_wrap">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение меню</h2>'.
				'<div>Меню предназначено для вывода в панели навигации сайта (например, верхнее меню) текстовых гиперссылок на ресурсы своего или стороннего сайта.</div>'.	
			'</div>'.			
			'<div class="help_titles_group"><h2 class="help_h2">Функции и возможности меню</h2>'.
				'<div><ol>'.
				'<li>Вывод страницы или раздела</li>'.
				'<li>Вывод одной и той же страницы в разных пунктах меню</li>'.
				'<li>Выбрать родительский пункт меню</li>'.
				'<li>Перемещение страниц вверх/вниз</li>'.
				'<li>Показать/скрыть пункт меню</li>'.
				'<li>Удалить меню</li>'.				
				'</ol>'.
				'</div>'.
				'</div>'.				
			'</div>'.			
			'<div class="help_titles_group"><h2 class="help_h2">Типы гиперссылок в меню</h2>'.
				'<div><ol>'.
				'<li>Гиперссылка на страницу сайта</li>'.
				'<li>Гиперссылка на каталог (например новости или интернет-магазин)</li>'.
				'<li>Гиперссылка сторонний ресурс</li>'.				
				'</ol>'.
				'</div>'.				
			'</div>'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Как создать пункт меню</h2>'.
				'<div>Перейдите на вкладку страницы, нажмите на кнопку "Добавить пункт меню". Заполните поле "Наименование пункта меню" по необходимости выберите "Родительский пункт меню", выберите "Тип ссылки", если тип ссылки "Страница" - выберите ниже страницу на которую будет осуществляться переход при нажатии, если тип ссылки "Ссылка" - сохраните пункт меню, откройте созданный пункт меню в вставьте в поле ссылка необходимый URl адрес стороннего ресурса.</div>'.	
			'</div>'.			
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<img class="img_bxsh" alt="" src="/administrator/help/template/images/2.webp" style="width:100%;margin-bottom: 20px;">'.
			'<img class="img_bxsh"alt="" src="/administrator/help/template/images/4.webp" style="width:400px;">'.
		'</div>'.
	'</div>';
