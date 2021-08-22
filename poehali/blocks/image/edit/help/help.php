<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Изображение';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Изображение»</h1>'.
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_wrap">'.	
				'<div class="help_titles_group"><h2 class="help_h2">Назначение блока изображение</h2>'.
				'<div>В данном боке вы можете добавлять изображение вместе с заголовком и описанием самого блока.</div>'.	
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Решаемые задачи</h2>'.
				'<div>Задачи данного блока состоят в том, что можно добавить к любому текст картинку по смыслу, чтобы читающий описание человек визуально представлял о чём он читает.</div>'.	
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Функции блока «Изображение»</h2>'.
				'<div><ol>'.
				'<li>Добавление изображения</li>'.
				'<li>Добавление любого цветного фона</li>'.
				'<li>Добавление текста со всеми текстовыми настройками, добавление таблицы в текст и изображение (по желанию).</li>'.
				'<li>Добавить подложку блоку, эта функция добавляет цветной фон блоку (цвет и прозрачность можно настроить).</li>'.
				'<li>Задать нужный шрифт, размер блока.</li>'.
				'</ol>'.
				'</div>'.
			'</div>'.	
			'<div class="help_titles_group"><h2 class="help_h2">Добавление картинки</h2>'.
				'<div>Чтобы добавить картинку вам нужно нажать на картинку выделенную пунктиром . Перед вами покажется данное меню, которому нужно следовать иначе ваша картинка станет не качественной или вылезет за рамки предоставленного блока. В данном случае картинка не должна быть больше 640 px.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Добавление текста в блок</h2>'.
				'<div>Чтобы добавить текст вам нужно нажать на большую букву "Т", после этого перед вами появится следующая таблица с настройками текста. Подробный разбор каждого пункта мы разбирали в предыдущей странице.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Добавление фона на блок</h2>'.
				'<div>Здесь мы можем добавлять любой свой цвет или добавить цвет и настроек сайта, который уже был часто использован всего таких цветов сайта может быть 2 или несколько.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Подложка</h2>'.
				'<div>В данной настройке мы можем изменить цвет подложки. Подложка создана для того, чтобы затемнить или осветлить блок с картинкой. Здесь же можно задать нужный нам процент непрозрачности подложки.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Размер блока</h2>'.
				'<div>Здесь мы указываем максимальную ширину блока, внешний отступ, внутренний отступ.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Шрифт</h2>'.
				'<div>В данном пункте мы настраиваем цвет шрифта, межстрочный интервал.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Текстовый блок имеет несколько предустановленных вариантов отображения, каждый из которых быстро и легко редактируется и настраивается под Ваши требования.</div>'.
			'</div>'.
		'</div>'.
		'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
			'<div> Все блоки быстро и легко редактируются, перемещаются между собой, отлично смотрятся на всех современных медиа-устройствах. В настройках можно изменить цвет, шрифт, максимальную ширину, отступы, загрузить фоновое изображение или выбрать цвет подложки.</div></div>'.	
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/4eyTqcWYXH0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/image/edit/help/images/1.webp" style="width:100%">'.			
		'</div>'.
	'</div>';
	
