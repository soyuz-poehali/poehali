<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Кейсы';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Кейсы 1»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока кейс 1</h2>'.
				'<div>Данный блок создан для описания или предоставления перечисления товара вашей компании.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока кейс 1</h2>'.
				'<div><ol>'.
				'<li>Добавление множества изображений.</li>'.
				'<li>Размещение кнопки с ссылкой.</li>'.
				'<li>Добавление текста.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок с кейсом 1 содержит одну форму выставления на страницу, но в меню блоков есть похожий блок в другой форме.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div> Все блоки быстро и легко редактируются, перемещаются между собой, отлично смотрятся на всех современных медиа-устройствах. В настройках можно добавлять несколько фотографий, менять шрифт на любой из представленных, добавлять кнопку с задаванием вопроса компании, добавить кнопку с гиппер ссылкой.</div></div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Редактирование текста</h2>'.	
				'<div>Редактирование осуществляется через визуальный редактор текста (html кода) <a href="/admin/help/ckeditor">CKEditir, здесь вы можете ознакомиться с инструкцией.</a></div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/jtSGfx4rk8w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/case/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
