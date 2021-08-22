<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Видео';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Видео»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока видео</h2>'.
				'<div>Данный блок предназначен для размещения любого видео с целью визуального представления вашего товара или компании.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока видео</h2>'.
				'<div><ol>'.
				'<li>Добавление текста к видео.</li>'.
				'<li>Кнопки подробнее - данная функция способна перенаправить вас на другую страницу, ссылку, блок и т.д с целью представления примера о котором говорится в видео.</li>'.
				'<li>Добавление несколько видео в одном блоке.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок с видео имеет 2 разных типа с размещением видео они представлены в меню блоков под названием "Видео YouTube"</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div> Все оба блока легко редактируются. В опциях блока вы можете - добавлять новое видео, редактировать видео по разрешению, указывать кнопку, которая будет перемещать вас на другой интернет ресурс, использовать другой цвет фона блока на те, которые вы захотите, устанавливать подложку для блока чтобы происходило его затемнение или осветления, менять шрифт текста на любой из представленных, менять размер блока.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/IELwEWEBdiU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/video/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
