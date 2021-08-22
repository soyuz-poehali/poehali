<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Панорама 360';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Панорама 360»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока «Панорама 360»</h2>'.
				'<div>Данный блок используется для размещения панорамного изображения на сайт.</div>'.
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока «Панорама 360»</h2>'.
				'<div><ol>'.
				'<li>Добавление и свободный просмотр панорамного изображения с текстовым описанием на сайт.</li>'.
				'<li>Изменение фона блока. Фоном может быть как цвет, так и изображение.</li>'.
				'<li>Изменение отступов и максимальной ширины блока.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок «Панорама 360» имеет единственный вариант отображения, который быстро и легко редактируется и настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок «Панорама 360» быстро и легко редактируется и отлично смотрится на всех современных медиа-устройствах. В настройках можно изменить максимальную ширину блока, отступы и фон.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/a60eovysbDI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/virtual_tour/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
