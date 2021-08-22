<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.css');
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.js');
$SITE->setHeadFile('/administrator/components/poehali/projects/template/mainpage.css');
$SITE->setHeadFile('/administrator/components/poehali/projects/template/mainpage.js');

$code =
	'<script>window.addEventListener("DOMContentLoaded", function(){'.
		'var contextmenu_section = ['.
			'["/admin/com/poehali/projects/edit", "dan_contextmenu_edit", "Редактировать"],'.	
			'["/admin/com/poehali/projects/up", "dan_contextmenu_up", "Вверх"],'.
			'["/admin/com/poehali/projects/down", "dan_contextmenu_down", "Вниз"],'.
			'["/admin/com/poehali/projects/active", "dan_contextmenu_pub", "Активный"],'.
			'["/admin/com/poehali/projects/inactive", "dan_contextmenu_unpub", "Неактивный"],'.
			'["/admin/com/poehali/projects/completed", "dan_contextmenu_block", "Завершённый"],'.
			'["/admin/com/poehali/projects/delete", "dan_contextmenu_delete", "Удалить"]'.
		'];'.
		'DAN.contextmenu.add("dan_contextmenu_ico", contextmenu_section, "left");'.
	'})</script>';
$SITE->setHeadCode($code);



$breadcrumbs_arr['/admin/com/poehali'] = 'Поехали';
$breadcrumbs_arr['/admin/com/poehali/projects'] = 'Проекты';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);
$POEHALI = new AdminPoehali();
$projects_arr = $POEHALI->projectGetProjects();

if ($projects_arr) {
	$n = 1;
	$tr = '';
	$tr_class_arr = array('unpub', 'active', '');
	foreach ($projects_arr as $project) {
		$tr_class = $tr_class_arr[$project['status']];
		
		// Темы
		$project_themes_arr = explode(',', $project['themes']);
		$project_themes_text_arr = [];
		foreach ($project_themes_arr as $project_theme_index) {
			$project_themes_text_arr[] = $POEHALI->themes_arr[$project_theme_index];
		}
		$project_themes_html = implode(', ', $project_themes_text_arr);
	
		$tr .= 
			'<tr class="'.$tr_class.'">'.
				'<td>'.$n.'</td>'.
				'<td>'.
					'<div class="dan_flex_row contextmenu_wrap"><svg class="dan_contextmenu_ico" title="Действия" data-id="'.$project['id'].'"><use xlink:href="/administrator/templates/images/sprite.svg#menu_1"></use></svg></div>'.
				'</td>'.
				'<td><a href="/admin/com/poehali/projects/edit/'.$project['id'].'">'.$project['name'].'</a></td>'.
				'<td>'.$project_themes_html.'</td>'.
				'<td><strong>'.rand(5, 50).'</strong></td>'.
				'<td><strong>'.rand(5, 50).'</strong></td>'.
				'<td>'.rand(1, 10).'</td>'.
				'<td>'.rand(1, 10).'</td>'.
				'<td>'.rand(1, 10).'</td>'.
				'<td>'.rand(1, 10).'</td>'.
				'<td>'.rand(1, 10).'</td>'.
				'<td>'.rand(1, 10).'</td>'.
				'<td>'.$project['date'].'</td>'.
				'<td></td>'.
			'</tr>';
		$n++;
	}

	$table = 
		'<div id="poehali_projects_container" class="dan_flex_row_start">'.
			'<table class="admin_table dan_even_odd">'.
				'<tr>'.
					'<th style="width:50px;">№</th>'.
					'<th style="width:50px;">&nbsp;</th>'.
					'<th style="width:200px;">Наименование</th>'.
					'<th style="width:200px;">Темы</th>'.
					'<th style="width:100px;">Блогеров</th>'.
					'<th style="width:100px;">Публикаций</th>'.
					'<th class="admin_table_th_sn">'.
						'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#youtube-color"></use></svg>'.
					'</th>'.
					'<th class="admin_table_th_sn">'.
						'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#instagram-color"></use></svg>'.
					'</th>'.
					'<th class="admin_table_th_sn">'.
						'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#tiktok-color"></use></svg>'.
					'</th>'.
					'<th class="admin_table_th_sn">'.
						'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#vk-color"></use></svg>'.
					'</th>'.
					'<th class="admin_table_th_sn">'.
						'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#facebook-color"></use></svg>'.
					'</th>'.
					'<th class="admin_table_th_sn">'.
						'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#web"></use></svg>'.
					'</th>'.
					'<th style="width:100px;">Дата</th>'.
					'<th></th>'.
				'</tr>'.
				$tr.
			'</table>'.
		'</div>';
} else{
	$table = '';
}

$SITE->content = 
	$breadcrumbs.
	'<div class="dan_flex_row_start">'.
		'<a href="/admin/com/poehali/projects/add" target="blank" class="ico_rectangle_container">'.
			'<svg><use xlink:href="/administrator/templates/images/sprite.svg#add"></use></svg>'.
			'<div class="ico_rectangle_text">Добавить проект</div>'.
		'</a>'.
		'<a href="/admin/com/poehali/projects/map" target="blank" class="ico_rectangle_container">'.
			'<svg><use xlink:href="/administrator/templates/images/sprite.svg#map"></use></svg>'.
			'<div class="ico_rectangle_text">Карта</div>'.
		'</a>'.
	'</div>'.
	'<h1>Проекты</h1>'.
	$table;
