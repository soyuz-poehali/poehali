<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Фотогалерея';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Фотогалерея»</h1>'.		
	'<div class="dan_flex_row dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока фотогалереи</h2>'.
				'<div>Данный блок используется для размещения определённого количества фотографий с небольшим описанием.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока фотогалереи</h2>'.
				'<div><ol>'.
				'<li>Автоматическая конвертация изображений при загрузке на сайт в веб-формат (.webp).</li>'.
				'<li>Изменение ориентации изображений при загрузке (1x1, 4x3 и 16x9). Функция настраивается в разделе «Опции» настроек блока.</li>'.
				'<li>Изменение размера, цвета и шрифта текста описания изображений. Функция настраивается в разделе «Шрифт, цвет» настроек блока.</li>'.
				'<li>Изменение ширины и внешних отступов блока, регулировка отступа между изображениями. Функция настраивается в разделе «Опции» настроек блока.</li>'.
				'<li>Изменение фона блока. Фоном может быть любой цвет - заданный в виде переменной или вручную, так-же в качестве фона можно загрузить изображение.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок фотогалереи имеет 3 вида, которые отличаются расположением текста описания. Каждый из всех трех типов фотогалереи быстро и легко редактируется, настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок фотогалереи быстро и легко редактируется, отлично смотрится на всех современных медиа-устройствах и имеет большой потенциал в кастомизации. В настройках можно изменить цвет, размер и шрифт текста описания, максимальную ширину самого блока, отступы, загрузить фоновое изображение или выбрать цвет подложки.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/imxfylChRdI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/photogallery/edit/help/images/photogallery.webp" style="width:100%">'.
		'</div>'.
	'</div>';
