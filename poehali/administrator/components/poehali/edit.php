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

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$POEHALI = new AdminPoehali();

$breadcrumbs_arr = array(
	'/admin/com/poehali' => 'Поехали', 
	'/admin/com/poehali/projects' => 'Проекты',
	'' => 'Проект '
);

$image_html = '';
if ($SITE->url_arr[4] == 'add') {
	$id = 0;
	$project['name'] = '';
	$project['date'] = '';
	$project['text'] = '';
	$project['ordering'] = $POEHALI->projectGetMaxOrdering() + 1;

	$act = 'insert';
	$title = 'Добавить проект';
	$button_text = 'Добавить';
	$status_check = 'checked';
	$chars_html = '';
	$breadcrumbs_arr[''] = 'Добавить проект';
	$multiple = '';
}

if ($SITE->url_arr[4] == 'edit') {
	$id = $SITE->url_arr[5];
	$project = $POEHALI->projectGet($id);
	if ($project['image'] != '') {
		$image_html =
		'<div class="dan_flex_row">'.
			'<div class="tc_l"></div>'.
			'<div class="tc_r"><img class="poehali_project_photo" src="/files/poehali/projects/'.$project['image'].'" alt=""></div>'.
		'</div>';
	}
	$data = $project['date'];
	$sn_url = $data['sn_url'];
	$project_themes_arr = explode(',', $project['themes']);
	$project_sn_arr = explode(',', $project['sn']);
	$act = 'update/'.$id;
	$title = 'Редактировать данные проекта';
	$button_text = 'Сохранить';
	$status_check = $project['status'] == 1 ? 'checked' : '';
	$type = '';
	$breadcrumbs_arr[''] = 'Редактировать данные проекта';
	$multiple = 'multiple';
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

// Активные соцсети
$sn_active_arr = array(
	'youtube' => '',
	'instagram' => '',
	'tiktok' => '',
	'vkontakte' => '',
	'facebook' => '',
	'site' => ''
);

foreach ($sn_active_arr as $key => $value) {
	if (in_array($key, $project_sn_arr))
		$sn_active_arr[$key] = 'checked';
}


$SITE->content = 
	breadcrumbs($breadcrumbs_arr).
	'<h1>'.$title.'</h1>'.
	'<div class="dan_bookmarks_nav">'.
		'<div class="dan_bookmark_head active" data-id="dan_bookmark_body_fio">Данные</div>'.
		'<div class="dan_bookmark_head" data-id="dan_bookmark_body_sn">Соцсети</div>'.
		'<div class="dan_bookmark_head" data-id="dan_bookmark_body_public">Публикации</div>'.
	'</div>'.
	'<form id="poehali_project_form" method="post" action="/admin/com/poehali/projects/'.$act.'" enctype="multipart/form-data">'.
		'<div class="tc_container">'.

			// ------- ДАННЫЕ -------
			'<div id="dan_bookmark_body_fio" class="dan_bookmark_body active">'.
				$image_html.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Изображение</div>'.
					'<div class="tc_r dan_flex_grow"><input id="image_file" name="image" type="file"></div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">ФИО</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input class="dan_input w_400" name="fio" required value="'.$project['fio'].'" title="ФИО">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Дата рожденья</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input class="dan_input" name="date_birth" type="date" value="'.$project['date_birth'].'" min="1930-01-01" max="2005-01-01" title="Введите дату рожденья" requered>'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">'.
						'Темы'.
						'<span class="dan_tooltip"><em>Темы</em><p>Темы, направления, которые освещает блогер</p></span>'.
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
					'<div class="tc_l">Активен (вкл.выкл)</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="status" class="dan_input" name="status" type="checkbox" value="1" '.$status_check.'>'.
						'<label for="status"></label>'.
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

			// ------- СОЦСЕТИ -------
			'<div id="dan_bookmark_body_sn" class="dan_bookmark_body">'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">YouTybe</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="youtube_active" class="dan_input" name="sn_active[youtube]" type="checkbox" value="youtube" '.$sn_active_arr['youtube'].'>'.
						'<label for="youtube_active"></label> '.
						'<input class="dan_input w_400" name="sn_url[youtube]" type="text" value="'.$sn_url['youtube'].'" placeholder="url">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Instagram</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="instagram_active" class="dan_input" name="sn_active[instagram]" type="checkbox" value="instagram"  '.$sn_active_arr['instagram'].'>'.
						'<label for="instagram_active"></label> '.
						'<input class="dan_input w_400" name="sn_url[instagram]" type="text" value="'.$sn_url['instagram'].'" placeholder="url">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Tiktok</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="tiktok_active" class="dan_input" name="sn_active[tiktok]" type="checkbox" value="tiktok" '.$sn_active_arr['tiktok'].'>'.
						'<label for="tiktok_active"></label> '.
						'<input class="dan_input w_400" name="sn_url[tiktok]" type="text" value="'.$sn_url['tiktok'].'" placeholder="url">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Vkontakte</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="vkontakte_active" class="dan_input" name="sn_active[vkontakte]" type="checkbox" value="vkontakte" '.$sn_active_arr['vkontakte'].'>'.
						'<label for="vkontakte_active"></label> '.
						'<input class="dan_input w_400" name="sn_url[vkontakte]" type="text" value="'.$sn_url['vkontakte'].'" placeholder="url">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Facebook</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="facebook_active" class="dan_input" name="sn_active[facebook]" type="checkbox" value="facebook"  '.$sn_active_arr['facebook'].'>'.
						'<label for="facebook_active"></label> '.
						'<input class="dan_input w_400" name="sn_url[facebook]" type="text" value="'.$sn_url['facebook'].'" placeholder="url">'.
					'</div>'.
				'</div>'.
				'<div class="dan_flex_row">'.
					'<div class="tc_l">Сайт</div>'.
					'<div class="tc_r dan_flex_grow">'.
						'<input id="site_active" class="dan_input" name="sn_active[site]" type="checkbox" value="site" '.$sn_active_arr['site'].'>'.
						'<label for="site_active"></label> '.
						'<input class="dan_input w_400" name="sn_url[site]" type="text" value="'.$sn_url['site'].'" placeholder="url">'.
					'</div>'.
				'</div>'.
			'</div>'.

			// ------- ПУБЛИКАЦИИ -------
			'<div id="dan_bookmark_body_public" class="dan_bookmark_body">'.
			'</div>'.

			'<div class="dan_flex_row p_20">'.
				'<div class="tc_l"><input id="button_submit" class="button_submit" type="submit" name="submit" value="Сохранить"></div>'.
				'<div class="tc_r dan_flex_grow"><a href="/admin/com/poehali/projects" class="button_cancel">Отменить</a></div>'.
			'</div>'.
		'</div>'.
	'</form>';
?>