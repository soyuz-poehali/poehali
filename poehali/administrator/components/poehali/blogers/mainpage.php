<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.css');
$SITE->setHeadFile('/lib/DAN/contextmenu/contextmenu.js');
$SITE->setHeadFile('/administrator/components/poehali/blogers/template/mainpage.css');
$SITE->setHeadFile('/administrator/components/poehali/blogers/template/mainpage.js');

$code =
	'<script>window.addEventListener("DOMContentLoaded", function(){'.
		'var contextmenu_section = ['.
			'["/admin/com/poehali/blogers/edit", "dan_contextmenu_edit", "Редактировать"],'.	
			'["/admin/com/poehali/blogers/up", "dan_contextmenu_up", "Вверх"],'.
			'["/admin/com/poehali/blogers/down", "dan_contextmenu_down", "Вниз"],'.
			'["/admin/com/poehali/blogers/pub", "dan_contextmenu_pub", "Активировать"],'.
			'["/admin/com/poehali/blogers/unpub", "dan_contextmenu_unpub", "Заблокировать"],'.
			'["/admin/com/poehali/blogers/delete", "dan_contextmenu_delete", "Удалить"]'.
		'];'.
		'DAN.contextmenu.add("dan_contextmenu_ico", contextmenu_section, "left");'.
	'})</script>';
$SITE->setHeadCode($code);



$breadcrumbs_arr['/admin/com/poehali'] = 'Поехали';
$breadcrumbs_arr['/admin/com/poehali/blogers'] = 'Блогеры';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);
$POEHALI = new AdminPoehali();
$blogers_arr = $POEHALI->blogerGetBlogers();

if ($blogers_arr) {
	$n = 1;
	$tr = '';
	foreach ($blogers_arr as $bloger) {
		$tr_class = $bloger['status'] == 1 ? '' : 'unpub';
		
		// Фото
		$image = $bloger['image'] == '' ? '' : '<img class="poehali_blogers_photo" src="/files/poehali/blogers/'.$bloger['image'].'">';
		
		// Темы
		$bloger_themes_arr = explode(',', $bloger['themes']);
		$bloger_themes_text_arr = [];
		foreach ($bloger_themes_arr as $bloger_theme_index) {
			$bloger_themes_text_arr[] = $POEHALI->themes_arr[$bloger_theme_index];
		}
		$bloger_themes_html = implode(', ', $bloger_themes_text_arr);
		
		// Соцсети
		/*
		$bloger_sn_arr = explode(',', $bloger['sn']);		
		$bloger_sn_svg_arr = [];
		foreach ($bloger_sn_arr as $key => $value) {
			$bloger_sn_svg_arr[] = 
			'<svg class="bloger_sn"><use xlink:href="/administrator/templates/images/sprite.svg#'.$value.'"></use></svg>';
		}
		$bloger_sn_html = implode(' ', $bloger_sn_svg_arr);
		*/
		
		$tr .= 
			'<tr class="'.$tr_class.'">'.
				'<td>'.$n.'</td>'.
				'<td>'.
					'<div class="dan_flex_row contextmenu_wrap"><svg class="dan_contextmenu_ico" title="Действия" data-id="'.$bloger['id'].'"><use xlink:href="/administrator/templates/images/sprite.svg#menu_1"></use></svg></div>'.
				'</td>'.
				'<td>'.$image.'</td>'.
				'<td><a href="/admin/com/poehali/blogers/edit/'.$bloger['id'].'">'.$bloger['fio'].'</a></td>'.
				'<td>'.$bloger_themes_html.'</td>'.
				'<td>Записей: <strong></strong><br>Просмотров: <strong></strong></td>'.
				'<td></td>'.
				'<td></td>'.
				'<td></td>'.
				'<td></td>'.
				'<td></td>'.
				'<td></td>'.
				'<td>'.$bloger['date_reg'].'</td>'.
				'<td>'.$bloger['date_last'].'</td>'.
				'<td></td>'.
			'</tr>';
		$n++;
	}

	$table = 
		'<div id="poehali_blogers_container" class="dan_flex_row_start">'.
			'<table class="admin_table dan_even_odd">'.
				'<tr>'.
					'<th style="width:50px;">№</th>'.
					'<th style="width:50px;">&nbsp;</th>'.
					'<th style="width:120px;">Фото</th>'.
					'<th style="width:200px;">ФИО</th>'.
					'<th style="width:200px;">Темы</th>'.
					'<th style="width:150px;">Статистика</th>'.
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
					'<th style="width:100px;">Регистр.</th>'.
					'<th style="width:100px;">Последн.</th>'.
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
		'<a href="/admin/com/poehali/blogers/add" target="blank" class="ico_rectangle_container">'.
			'<svg><use xlink:href="/administrator/templates/images/sprite.svg#add"></use></svg>'.
			'<div class="ico_rectangle_text">Добавить блогера</div>'.
		'</a>'.
		/*'<a href="/admin/com/poehali/blogers/invite" target="blank" class="ico_rectangle_container">'.
			'<svg><use xlink:href="/administrator/templates/images/sprite.svg#email"></use></svg>'.
			'<div class="ico_rectangle_text">Пригласить блогеров</div>'.
		'</a>'.*/
	'</div>'.
	'<h1>Блогеры</h1>'.
	$table;
