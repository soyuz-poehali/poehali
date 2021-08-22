<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Вертикальный скроллинг';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Вертикальный скроллинг»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение «Вертикальный скроллинг»</h2>'.
				'<div>Данный блок используется для размещения одного изображения книжного формата с описанием.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции «Вертикальный скроллинг»</h2>'.
				'<div><ol>'.
				'<li>Загрузка изображений книжного формата и добавление текстового описания.</li>'.
				'<li>Изменение фона блока. Фоном может быть как цвет, так и изображение.</li>'.
				'<li>Настройка максимальной ширины и отступов блока.</li>'.
				'<li>Изменение шрифта, размера, цвета и межстрочного интервала текста описания.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Текстовый блок имеет единственный вариант отображения, который быстро и легко редактируется и настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок быстро и легко редактируется, отлично смотрятся на всех современных медиа-устройствах. В настройках можно изменить цвет, шрифт, размер и межстрочный интервал текста описания, максимальную ширину и отступы самого блока, загрузить фоновое изображение или выбрать цвет фона.</div></div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Редактирование текста</h2>'.	
				'<div>Редактирование осуществляется через визуальный редактор текста (html кода) <a href="/admin/help/ckeditor">CKEditir, здесь вы можете ознакомиться с инструкцией.</a></div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/I1FYCb0_S30" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/scrolling_vertical/edit/help/images/scrolling_vertical.webp" style="width:100%">'.
		'</div>'.
	'</div>';
