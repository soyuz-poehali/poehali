<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Карта Яндекс';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Карта Яндекс»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока «Карта Яндекс»</h2>'.
				'<div>Данный блок используется для размещения кастомной карты с возможностью установки меток с описанием.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока «Карта Яндекс»</h2>'.
				'<div><ol>'.
				'<li>Добавление и удаление меток на карте с описанием. Есть возможность выбора типа метки в настройках.</li>'.
				'<li>Регулировка масштаба карты. Если Вы сохранили карту не правильно, ее всегда можно сохранить заново, предварительно отрегулировав масштаб.</li>'.
				'<li>Изменение максимальной ширины/высоты карты и отступов.</li>'.
				'<li>Изменение фона карты. Фоном может быть как цвет, так и загруженное Вами изображение.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок «Карта Яндекс» имеет два предустановленных вариантов отображения, каждый из которых быстро и легко редактируется и настраивается под Ваши требования. Отличия между вариантами заключаются в максимальной ширине блоков.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Оба блока быстро и легко редактируются и отлично смотрятся на всех современных медиа-устройствах. В настройках можно изменить фон блока, тип метки, максимальную ширину и высоту а так-же отступы.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/nNWeJV0RBiE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/mapsyandex/edit/help/images/mapsyandex.webp" style="width:100%">'.
		'</div>'.
	'</div>';
