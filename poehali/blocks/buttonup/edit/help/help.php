<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Наверх';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Наверх»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока «Наверх»</h2>'.
				'<div>Данный блок используется для возвращения пользователя к шапке сайта. Перемещение к шапке сайта после нажатия на блок сопровождается плавной анимацией.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока «Наверх»</h2>'.
				'<div><ol>'.
				'<li>Перемещение пользователя в шапку сайта при нажатии на блок.</li>'.
				'<li>Изменение цвета и размера блока.</li>'.
				'<li>Изменение позиции блока относительно краев веб-страницы.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок «Наверх» имеет несколько предустановленных вариантов отображения, каждый из которых быстро и легко редактируется и настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок быстро и легко редактируется, отлично смотрится на всех современных медиа-устройствах. В настройках можно изменить размер и цвет блока, а так-же задать ему позиционирование относительно краев веб-страницы.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/s6U9ljRZlto" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/buttonup/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
