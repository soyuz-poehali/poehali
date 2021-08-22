<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Страницы';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Страницы</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
		'<div class="help_titles_wrap">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение страниц</h2>'.
				'<div>Страницы предназначены для добавления контента на сайт. Страницы могут содержать текстовые блоки, фотогалерею, видео, форму обратной связи. <a href="/admin/help/blocks">Смотреть все блоки.</a></div>'.	
			'</div>'.			
			'<div class="help_titles_group"><h2 class="help_h2">Функции и возможности страниц</h2>'.
				'<div><ol>'.
				'<li>Страница может быть главной или внутренней.</li>'.
				'<li>Опубликовать / скрыть</li>'.
				'<li>Добавить на сайт без вывода пункта меню</li>'.
				'<li>Прописать свой url и seo теги</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.				
			'</div>'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Создание страницы</h2>'.
				'<div>Для создания страницы сайта перейдите на вкладку страницы, нажмите на кнопку добавить страницу. Заполните поле с заголовком страницы, нажмите сохранить. Страница создана и отображается в неразмеченных страницах "Страницы без пунктов меню".</div>'.	
			'</div>'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Редактирование страницы</h2>'.
				'<div>Редактирование содержимого страницы происходит через режим визуального редактирования. Чтобы перейти к редактированию страницы Вам нужно привязать ее к пункту меню, а затем нажать кнопку "Ред." в верхней части экрана, для открытия режима визуального редактирования. Если страница не привязана к пункту меню Вы можете открыть ее набрав в адресной строке полный путь до страницы.</div>'.	
			'</div>'.			
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.
			'<img class="img_bxsh" alt="" src="/administrator/help/template/images/2.webp" style="width:100%;margin-bottom: 20px;">'.
			'<img class="img_bxsh"alt="" src="/administrator/help/template/images/3.webp" style="width:400px;">'.
		'</div>'.
	'</div>';
