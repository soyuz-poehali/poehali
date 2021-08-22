<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Обратный звонок';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Обратный звонок»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока обратный звонок</h2>'.
				'<div>Данный блок создан для обратной связи с вами или вашей организации.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока с обратной связью</h2>'.
				'<div><ol>'.
				'<li>Сделать звонок в один клик.</li>'.
				'<li>Красивая и яркая иконка.</li>'.
				'<li>Маленький формат иконки.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Данный блок содержит один вариант размещения на страницу с красивой яркой подсветкой.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок с обратной связью легко редактируется и прост в использовании. В нём вы сможете выбрать цвет иконки обратной связи, поменять размер иконки, изменить положение иконки сверху или снизу.</div></div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Редактирование текста</h2>'.	
				'<div>Редактирование осуществляется через визуальный редактор текста (html кода) <a href="/admin/help/ckeditor">CKEditir, здесь вы можете ознакомиться с инструкцией.</a></div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/tg6L45p7oDw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/callback/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
