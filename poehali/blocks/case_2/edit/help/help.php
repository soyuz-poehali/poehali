<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Кейсы 2';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Кейсы 2»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока «Кейс 2»</h2>'.
				'<div>Данный блок используется для размещения определенного количества фотографий с описанием в виде текста и иконок. В блок можно загрузить не более 5 фотографий.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока «Кейс 2»</h2>'.
				'<div><ol>'.
				'<li>Автоматическая конвертация изображений при загрузке на сайт в веб-формат (.webp).</li>'.
				'<li>Добавление до 5 фотографий с описанием в виде текста и иконок. Возможность добавления гиперссылок.</li>'.
				'<li>Возможность редактирования текста, текста иконок и выбора самих иконок из сотен предустановленных вариантов.</li>'.
				'<li>Возможность изменения размера блока, внутренних и внешних отступов, цвета, размера межстрочного интервала и шрифта текста описания и фона блока.</li>'.
				'<li>Возможность быстро и удобно менять местами загруженные изображения и выбранные иконки.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>«Кейсы 2» имеет единственный вариант отображения, который быстро и легко редактируется и настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок «Кейсы 2» легко редактируется и отлично смотрится на всех современных медиа-устройствах. В настройках можно изменить фон блока, максимальную ширину и отступы, цвет, размер, шрифт и межстрочный интервал текста описания.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/xR5kZUSY2PI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/case_2/edit/help/images/case_2.webp" style="width:100%">'.
		'</div>'.
	'</div>';
