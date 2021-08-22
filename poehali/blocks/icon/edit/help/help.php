<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Иконки';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Иконки»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока иконки</h2>'.
				'<div>Данный блок создан для краткого описания или подчёркивания главных функций вашей организации, товара или сайта.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока с иконками</h2>'.
				'<div><ol>'.
				'<li>Добавление большого количества иконок.</li>'.
				'<li>Добавлять краткое описание под каждую иконку.</li>'.
				'<li>Большое разнообразие форм иконок.</li>'.
				'<li>Выбор любого цвета для иконок.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок с иконками содержит разные формы добавления от круглых до квадратных с разными вариантов цветов.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div> Данный блок легко редактируется и прост в использовании в нём вы можете - менять цвет иконок, редактировать и менять шрифт текста, добавлять подложку к блоку, менять фон блока на любой из представленных в нашей палитре цветов, менять размер иконок, менять цвет шрифта.</div></div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Редактирование текста</h2>'.	
				'<div>Редактирование осуществляется через визуальный редактор текста (html кода) <a href="/admin/help/ckeditor">CKEditir, здесь вы можете ознакомиться с инструкцией.</a></div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/ePSQoAk4WDA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/icon/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
