<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Портфолио сайтов';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блок «Портфолио сайтов»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение блока портфолио для сайтов</h2>'.
				'<div>Данный блок создан для демонстрации вашего сайта на главную страницу.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции блока портфолио для сайта</h2>'.
				'<div><ol>'.
				'<li>Добавление фото.</li>'.
				'<li>Добавление текста.</li>'.
				'<li>Добавление нескольких блоков.</li>'.
				'<li>Добавление ссылок на другую информацию.</li>'.
				'<li>Красивая прокрутка внутри блока.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Блок портфолио для сайта имеет один вид добавления на вашу страницу сайта.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div> Целый блок редактируется очень просто и легко просматривается на всех медиа источниках. В опциях блока вы сможете заменить картинку для красивого отображения, менять шрифт на любой из представленных, сможете указать ссылку на блок для того чтобы при нажатии вы перемещались на другой интернет ресурс, менять цвет на любой другой из представленной палитры цветов.</div></div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Редактирование текста</h2>'.	
				'<div>Редактирование осуществляется через визуальный редактор текста (html кода) <a href="/admin/help/ckeditor">CKEditir, здесь вы можете ознакомиться с инструкцией.</a></div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/xMaFvTjFMa8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/site_portfolio/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
