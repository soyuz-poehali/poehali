<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = isset($_POST['style']) ? intval($_POST['style']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

// Стиль и формат
if ($style) 
	$content['style'] = $style;

if (!$content['line_height']) 
	$content['line_height'] = 1;

$style_selected = array_fill(1, 3, '');
$style_selected[$content['style']] = 'selected';

$format_selected = array_fill(1, 5, '');
$format_selected[$content['format']] = 'selected';


// Ширина
$wrap_width_select_100 = $wrap_width_select_1600 = $wrap_width_select_1440 = $wrap_width_select_1280 = '';

switch ($content['max_width']) {
	case '100': $wrap_width_select_100 = 'selected'; break;
	case '1600': $wrap_width_select_1600 = 'selected'; break;
	case '1440': $wrap_width_select_1440 = 'selected'; break;
	case '1280': $wrap_width_select_1280 = 'selected'; break;
}


// Фон
$bg_n_selected = $bg_1_selected = $bg_2_selected = $bg_3_selected = $bg_c_selected = $bg_color_out = '';
$bg_color_man = 'style="display:none;"';

switch ($content['bg_type']) {
	case '1': $bg_1_selected = 'selected'; 
		break;
	case '2': $bg_2_selected = 'selected'; 
		break;
	case '3': $bg_3_selected = 'selected'; 
		break;
	case 'c': $bg_c_selected = 'selected';
		$bg_color_man = '';
	break;
	default: $bg_n_selected = 'selected'; 
		break;
}


// Цвет
if ($content['color'] == 'var(--font-color)') 
	$content['color'] = '#444444';

if ($content['font_size'] == 'var(--font-size)') 
	$content['color'] = 16;


// Вуаль
if (isset($content['fog_color'])) {
	$fog_html =
		'<tr>'.
			'<td class="e_td_right">Цвет вуали</td>'.
			'<td>'.
				'<input id="e_block_modal_fog_color" class="dan_input" type="color" value="'.$content['fog_color'].'">'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Непрозрачность вуали</td>'.
			'<td>'.
				'<div class="e_flex_center_h">'.
					'<input id="e_block_modal_fog_opacity" type="range" min="10" max="100" step="5" value="'.($content['fog_opacity'] * 100).'">'.
					'<div class="e_modal_range_out"><span id="e_block_modal_fog_opacity_out">'.($content['fog_opacity'] * 100).'</span> %</div>'.
				'</div>'.
			'</td>'.
		'</tr>';
} else {
	$fog_html = '';
}


$html =
'<div class="dan_2_modal_content_center_mobile">'.
	'<h2>Настройки фотогалереи</h2>'.
	'<details class="dan_accordion">'.
		'<summary>Опции</summary>'.
		'<table id="e_block_modal_photogallery_options" class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Тип</td>'.
				'<td>'.
					'<select id="e_block_modal_photogallery_style" name="style" class="dan_input">'.
						'<option selected value="1" '.$style_selected[1].'>Обычная</option>'.
						'<option value="2" '.$style_selected[2].'>C появлением текстового поля</option>'.
						'<option value="3" '.$style_selected[3].'>С подъёмом текстового поля</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Формат превью<br>для новых изображений</td>'.
				'<td>'.
					'<select id="e_block_modal_photogallery_format" name="format" class="dan_input">'.
						'<option value="1" '.$format_selected[1].'>Квадрат 1 х 1</option>'.
						'<option value="2" '.$format_selected[2].'>Горизонтальный 4 х 3</option>'.
						'<option value="3" '.$format_selected[3].'>Горизонтальный 16 х 9</option>'.
						'<option value="4" '.$format_selected[4].'>Вертикальный 4 х 3</option>'.
						'<option value="5" '.$format_selected[5].'>Вертикальный 16 х 9</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Максимальная ширина</td>'.
				'<td>'.
					'<select id="e_block_modal_max_width" class="dan_input">'.
						'<option value="100" '.$wrap_width_select_100.'>100%</option>'.
						'<option value="1600" '.$wrap_width_select_1600.'>1600px</option>'.
						'<option value="1440" '.$wrap_width_select_1440.'>1440px</option>'.
						'<option value="1280" '.$wrap_width_select_1280.'>1280px</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Внешний отступ (от подложки)</td>'.
				'<td><input id="e_block_modal_margin" class="dan_input" type="number" min="0" max="100" value="'.$content['margin'].'"></td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Отступ между изображениями</td>'.
				'<td><input id="e_block_modal_padding" class="dan_input" type="number" min="0" max="100" value="'.$content['padding'].'"></td>'.
			'</tr>'.		
		'</table>'.
	'</details>'.
	'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Фон</summary>'.
		'<div>'.
		'<table class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Фон блока</td>'.
				'<td>'.
					'<select id="e_block_modal_bg_type" class="dan_input" name="bg_type">'.
						'<option '.$bg_n_selected.' value="">Нет</option>'.
						'<option '.$bg_1_selected.' value="1">Цвет 1 из настроек сайта</option>'.
						'<option '.$bg_2_selected.' value="2">Цвет 2 из настроек сайта</option>'.
						'<option '.$bg_3_selected.' value="3">Цвет 3 из настроек сайта</option>'.
						'<option '.$bg_c_selected.' value="c">Свой цвет</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
		'</table>'.
		'<div id="e_block_modal_container_bg_color">'.$bg_color_out.'</div>'.
			'<table id="e_block_modal_container_bg_color_mannuale" class="e_table_admin" '.$bg_color_man.'>'.
				'<tr>'.
					'<td class="e_td_right">Цвет, установленный вручную</td>'.
					'<td><input id="e_block_modal_container_bg_color_input" class="dan_input" type="color" name="bg_color" value="'.$content['bg_color'].'"></td>'.
				'</tr>'.
			'</table>'.
		'</div>'.
	'</details>'.
	'<details class="dan_accordion">'.
		'<summary>Шрифт, цвет</summary>'.
		'<table id="e_block_modal_photogallery_options" class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Размер шрифта заголовка</td>'.
				'<td>'.
					'<input id="e_block_modal_title_size" class="dan_input" type="number" min="16" max="36" value="'.$content['title_size'].'">'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Размер шрифта дополнительного текста</td>'.
				'<td>'.
					'<input id="e_block_modal_font_size" class="dan_input" type="number" min="14" max="36" value="'.$content['font_size'].'">'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Цвет шрифта</td>'.
				'<td>'.
					'<input id="e_block_modal_font_color" class="dan_input" type="color" value="'.$content['color'].'">'.
				'</td>'.
			'</tr>'.
			$fog_html.
		'</table>'.
	'</details>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div>'.
			'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">'.
		'</div>'.
		'<div>'.
			'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">'.
		'</div>'.
	'</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html, 'style' => $content['style']));

exit;

?>