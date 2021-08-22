<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Слайдер';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Слайдер»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока слайдера</h2>'.
				'<div>Прямым назначением блока является размещение определённого количества тематических фотографий высокого качества с описанием для демонстрации имиджа сайта.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока слайдера</h2>'.
				'<div><ol>'.
				'<li>Размещение и удаление переключающихся со временем изображений с описанием.</li>'.
				'<li>Настройка навигации в слайдах, времени задержки между их переключением, затемнением и ширины и высоты самого блока.</li>'.
				'<li>Настройка размера текста слайдов.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок слайдера имеет два предустановленных варианта отображения, которые отличаются своей шириной и расположением текста описания. Каждый из них быстро и легко редактируется и настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div>Блок слайдера быстро и легко редактируется, отлично смотрится на всех современных медиа-устройствах и имеет большой потенциал в кастомизации. В настройках можно изменить размер текста описания слайдов и межстрочный интервал, максимальную ширину и высоту самого блока, отступы, панель навигации в слайдах, задержку между ними, их затемнение и анимацию появления. В качестве фона блока можно использовать любой цвет - заданный в виде переменной или вручную, так-же в качестве фона можно загрузить изображение.</div></div>'.	
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/SYEyHPZ_ITU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/slider/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
