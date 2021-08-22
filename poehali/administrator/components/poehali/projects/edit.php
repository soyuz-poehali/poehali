<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/administrator/templates/css/templates.css');
$SITE->setHeadFile('/lib/DRAG_DROP/DRAG_DROP.css');
$SITE->setHeadFile('/lib/DRAG_DROP/DRAG_DROP.js');
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.css');
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.js');
$SITE->setHeadFile('/lib/DAN/bookmarks/bookmarks.css');
$SITE->setHeadFile('/lib/DAN/bookmarks/bookmarks.js');
$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.css');
$SITE->setHeadFile('/lib/DAN/tooltip/tooltip.js');
$SITE->setHeadFile('/administrator/components/poehali/projects/template/edit.css');
$SITE->setHeadFile('/administrator/components/poehali/projects/template/edit.js');
$SITE->setHeadFile('/administrator/plugins/ckeditor_textarea/ckeditor.js');

$SITE->setHeadCode('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$POEHALI = new AdminPoehali();

$breadcrumbs_arr = array(
	'/admin/com/poehali' => 'Поехали', 
	'/admin/com/poehali/projects' => 'Проекты',
	'' => 'Проект '
);

$status_arr = array_fill(0, 3, '');
if ($SITE->url_arr[4] == 'add') {
	$id = 0;
	$project['name'] = '';
	$project['date'] = '';
	$project['text'] = '';
	$project['ordering'] = $POEHALI->projectGetMaxOrdering() + 1;
	$project_themes_arr = [];
	$project_blogers_arr = [];
	$project['coordinates'] = '';
	$sn_url = array(
		'youtube' => '',
		'instagram' => '',
		'tiktok' => '',
		'vkontakte' => '',
		'facebook' => '',
		'site' => ''
	);
	$act = 'insert';
	$title = 'Добавить проект';
	$button_text = 'Добавить';

	$chars_html = '';
	$breadcrumbs_arr[''] = 'Добавить проект';
}

if ($SITE->url_arr[4] == 'edit') {
	$id = $SITE->url_arr[5];
	$project = $POEHALI->projectGet($id);
	$data = $project['data'];
	$project_themes_arr = explode(',', $project['themes']);
	$project_blogers_arr = $POEHALI->projectBlogersGet($id);
	$act = 'update/'.$id;
	$title = 'Редактировать данные проекта';
	$button_text = 'Сохранить';
	$status_arr[$project['status']] = 'selected';
	$breadcrumbs_arr[''] = 'Редактировать данные проекта';
}

// Темы
$themes_options_html = '';
foreach ($POEHALI->themes_arr as $key => $value) {
	$selected = '';
	foreach($project_themes_arr as $project_section) {
		if(in_array($key, $project_themes_arr))
			$selected = 'selected';
	}
	$themes_options_html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
}

$html = '';
foreach ($project_blogers_arr as $bloger) {
	$html .= 
	'<div class="poehali_blogers_list_wrap drag_drop_ico" data-id="'.$bloger['b_id'].'">'.
		'<img src="/files/poehali/blogers/'.$bloger['b_image'].'">'.
		'<div class="poehali_blogers_list_fio">'.$bloger['b_fio'].'</div>'.
	'</div>';	
}

$SITE->content = 
	breadcrumbs($breadcrumbs_arr).
	'<h1>'.$title.'</h1>'.
	'<div class="dan_bookmarks_nav">'.
		'<div class="dan_bookmark_head active" data-id="dan_bookmark_body_project">Проект</div>'.
		'<div class="dan_bookmark_head" data-id="dan_bookmark_body_map">Карта</div>'.
		'<div class="dan_bookmark_head" data-id="dan_bookmark_body_blogers">Блогеры</div>'.
	'</div>'.
	'<form id="poehali_project_form" method="post" action="/admin/com/poehali/projects/'.$act.'" enctype="multipart/form-data" data-project_id="'.$id.'">'.
		'<div class="tc_container">'.

			// ------- ПРОЕКТ -------
			'<div id="dan_bookmark_body_project" class="dan_bookmark_body active">'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Наименование</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="poehali_project_name" class="dan_input w_400" name="name" required value="'.$project['name'].'" title="Заполните наименование проекта">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Дата проекта</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input class="dan_input" name="date" type="date" value="'.$project['date'].'" min="2021-01-01" max="2050-01-01" title="Введите дату проекта" requered>'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">'.
						'Темы'.
						'<span class="dan_tooltip"><em>Темы</em><p>Темы, направления, которые освещает проект</p></span>'.
					'</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<select class="dan_input com_poehali_projects_themes w_400" name="themes[]" multiple required title="Выбрать темы">'.
							$themes_options_html.
						'</select>'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l_text">Заметки</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<textarea name="editor1">'.$project['text'].'</textarea>'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Статус</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<select class="dan_input" name="status">'.
							'<option value="0" '.$status_arr[0].'>Не активный</option>'.
							'<option value="1" '.$status_arr[1].'>Активный</option>'.
							'<option value="2" '.$status_arr[2].'>Выполненный</option>'.
						'</select>'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Порядок следования</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input class="dan_input" name="ordering" type="number" value="'.$project['ordering'].'">'.
						'<div id="url_status"></div>'.
					'</div>'.
				'</div>'.
			'</div>'.

			// ------- КАРТА -------
			'<div id="dan_bookmark_body_map" class="dan_bookmark_body">'.

				'<div id="poehali_project_mapsyandex_status">'.
					'<div><b>РЕЖИМ УСТАНОВКИ КООРДИНАТЫ ОБЪЕКТА.</b> <br>Нажмите в нужной области карты для установки точки. При необходимости перетащите точку. После окончания нажмите кнопку "Установить координаты"</div>'.
					'<div id="poehali_project_mapsyandex_set" class="button_cancel">Установить координаты</div>'.
				'</div>'.
				'<div id="poehali_project_mapsyandex_mark_add" class="dan_flex_row">'.
					'<div class="tc_l">'.					
					'</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<div id="poehali_project_mapsyandex_button" class="button_set" type="button">Установить точку</div>'.	
					'</div>'.
				'</div>'.				
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Координаты объекта</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="poehali_project_mapsyandex_coordinates" class="dan_input w_400" name="coordinates" type="text" value="'.$project['coordinates'].'" readonly>'.
					'</div>'.
				'</div>'.
				'<div id="poehali_project_mapsyandex" data-id="1"></div>'.
			'</div>'.

			// ------- БЛОГЕРЫ -------
			'<div id="dan_bookmark_body_blogers" class="dan_bookmark_body">'.
				'<div id="poehali_project_mapsyandex_bloger_add" class="button_set">Добавить блогера</div>'.
				'<div id="poehali_project_mapsyandex_blogers_list" class="dan_flex_row_start">'.$html.'</div>'.
			'</div>'.

			'<div class="dan_flex_row p_20">'.
				'<div class="tc_l"><input id="button_submit" class="button_submit" type="submit" name="submit" value="Сохранить"></div>'.
				'<div class="tc_r dan_flex_grow"><a href="/admin/com/poehali/projects" class="button_cancel">Отменить</a></div>'.
			'</div>'.
		'</div>'.
	'</form>';
?>