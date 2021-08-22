<?php
defined('AUTH') or die('Restricted access');

$content =
	'<h1 class="help_h1">Блок «Текст»</h1>'.		
	'<div class="dan_flex_row help_overflow_unset ">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение текстового блока</h2>'.
				'<div>Назначения текстового блока состоит в том, чтобы добавлять описание или размещать фотографию к приложенному тексту.</div>'.	
			'</div>'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group"><h2 class="help_h2">Функции текстового блока</h2>'.
				'<div><ol>'.
				'<li>Написание, вставка, редактирование текста.</li>'.
				'<li>Добавление гиперссылок. С помощью них можно перейти с одной страницы сайта на другую.</li>'.
				'<li>Менять шрифт и размер текста. С помощью этого можно сделать шрифт больше или меньше, поменять тест в более жирный или прописной вариант</li>'.
				'<li>Добавление таблиц. С помощью данной функции можно вставлять нужную нам информацию по-порядку, также с цифрами и прочим.</li>'.
				'<li>Добавление специальных символов. С помощью них можно обозначать нужную строку в тексте.</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
				'<div>Текстовый блок имеет несколько предустановленных вариантов отображения, каждый из которых быстро и легко редактируется и настраивается под Ваши требования.</div>'.
				'</div>'.
				'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
				'<div> Все блоки быстро и легко редактируются, перемещаются между собой, отлично смотрятся на всех современных медиа-устройствах. В настройках можно изменить цвет, шрифт, максимальную ширину, отступы, загрузить фоновое изображение или выбрать цвет подложки.</div></div>'.	
				'<div class="help_titles_group"><h2 class="help_h2">Редактирование текста</h2>'.	
				'<div>Редактирование осуществляется через визуальный редактор текста (html кода) <a href="/admin/help/ckeditor">CKEditir, здесь вы можете ознакомиться с инструкцией.</a></div></div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="100%" height="580" src="https://www.youtube.com/embed/CWg5mXU04AU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/text/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';

if (isset($admin_help)) {  // Вывод help в админке
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';
	$SITE->setHeadFile('/administrator/help/template/style.css');
	$breadcrumbs_arr['/admin/help'] = 'Помощь';
	$breadcrumbs_arr[''] = 'Текст';
	$breadcrumbs = breadcrumbs($breadcrumbs_arr);
	$SITE->content = $content;
} else {  // Вывод help в режиме edit
	echo json_encode(array('answer' => 'success', 'content' => $content));
	exit;
}

?>