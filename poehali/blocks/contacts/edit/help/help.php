<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Контакты';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Контакты»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока контакты</h2>'.
				'<div>Данный блок создан для обратной связи с вами или вашей компанией, плюс приятным дополнением в этом блоке является то, что в нём присутствует карта при помощи, которой можно найти вашу организацию.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции контактного блока</h2>'.
				'<div><ol>'.
				'<li>Добавление множество форм обратной связи из представленных в меню "Выбрать поле"</li>'.
				'<li>Добавление метки на карте вашей компании.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок контакты содержит одну форму добавления на вашу страницу сайта.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок контакты прост в редактировании в нём вы можете - менять размер блока, выбирать множество шрифтов и размеров текста, использовать различные цвета из нашей палитры красок, добавлять подложку на блок.</div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/qVsMhBHFN9g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/contacts/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
