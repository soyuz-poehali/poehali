<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/DAN/hexToRGB/hexToRGB.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/link_page_block.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = isset($_POST['style']) ? intval($_POST['style']) : false;

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

if ($style)
	$content['style'] = $style;

if(!$content['line_height']) 
	$content['line_height'] = 1.2;

$style_selected = array_fill(1, 3, '');
$style_selected[$content['style']] = 'selected';

$format_selected = array_fill(1, 5, '');
$format_selected[$content['image_format']] = 'selected';

$button_checked = $content['button'] == 1 ? 'checked' : '';

// Размер блока и отступы
$wrap_width_select_100 = $wrap_width_select_1600 = $wrap_width_select_1440 = $wrap_width_select_1280 = '';

switch ($content['max_width']) {
	case '100': $wrap_width_select_100 = 'selected'; break;
	case '1600': $wrap_width_select_1600 = 'selected'; break;
	case '1440': $wrap_width_select_1440 = 'selected'; break;
	case '1280': $wrap_width_select_1280 = 'selected'; break;
	default: $wrap_width_select_custom = 'selected'; break;		
}

$arr = array(100, 1600, 1440, 1280);
$wrap_width_select_custom_option = !in_array($content['max_width'], $arr) ? '<option value="'.$content['max_width'].'" '.$wrap_width_select_custom.'>'.$content['max_width'].'</option>' : '';

// Цвета из css
$css_file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/style.css', true);
preg_match("/\--\w*-1:\srgb\((.*)\)/", $css_file, $matches_1);
preg_match("/\--\w*-2:\srgb\((.*)\)/", $css_file, $matches_2);
preg_match("/\--\w*-3:\srgb\((.*)\)/", $css_file, $matches_3);

$color_1 = rgb_to_hex($matches_1[1]);
$color_2 = rgb_to_hex($matches_2[1]);
$color_3 = rgb_to_hex($matches_3[1]);

$html =
'<h2>Настройки блока</h2>'.
'<details class="dan_accordion">'.
	'<summary>Опции</summary>'.
	'<table class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Тип:</td>'.
			'<td>'.
				'<select id="e_block_modal_packages_style" name="style" class="dan_input">'.
					'<option selected value="1" '.$style_selected[1].'>C подъёмом заднего фона</option>'.
					'<option value="2" '.$style_selected[2].'>Статичная</option>'.
				'</select>'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Формат изображений</td>'.
			'<td>'.
				'<select id="e_block_modal_packages_format" name="format" class="dan_input">'.
					'<option value="1" '.$format_selected[1].'>Квадрат 1 х 1</option>'.
					'<option value="2" '.$format_selected[2].'>Горизонтальный 4 х 3</option>'.
					'<option value="3" '.$format_selected[3].'>Горизонтальный 16 х 9</option>'.
					'<option value="4" '.$format_selected[4].'>Вертикальный 4 х 3</option>'.
					'<option value="5" '.$format_selected[5].'>Вертикальный 16 х 9</option>'.
				'</select>'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Цвет фона основного текста:</td>'.
			'<td><input id="e_block_modal_packages_text_1_bg" class="dan_input" type="color" value="'.$content['text_1_bg'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Цвет фона дополнительного текста:</td>'.
			'<td><input id="e_block_modal_packages_text_2_bg" class="dan_input" type="color" value="'.$content['text_2_bg'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Отображать кнопку:</td>'.
			'<td><input id="e_block_modal_packages_button" class="dan_input" type="checkbox" value="1" '.$button_checked.'><label for="e_block_modal_packages_button"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Цвет текста кнопки</td>'.
			'<td>'.
				'<div class="dan_flex_center">'.
					'<input class="dan_input" id="e_block_modal_packages_button_color" type="color" value="'.$content['button_color'].'">'.
					'<div id="e_block_modal_packages_button_color_wrap" class="e_block_modal_color_round_wrap">'.
						'<div class="e_block_modal_color_round" style="background-color:var(--color-1)" data-color_var="var(--color-1)" data-color="'.$color_1.'"></div>'.
						'<div class="e_block_modal_color_round" style="background-color:var(--color-2)" data-color_var="var(--color-2)" data-color="'.$color_2.'"></div>'.
						'<div class="e_block_modal_color_round" style="background-color:var(--color-3)" data-color_var="var(--color-3)" data-color="'.$color_3.'"></div>'.
					'</div>'.
				'</div>'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Цвет фона кнопки:</td>'.
			'<td>'.
				'<div class="dan_flex_center">'.
					'<input class="dan_input" id="e_block_modal_packages_button_bg_color" type="color" value="'.$content['button_bg_color'].'">'.
					'<div id="e_block_modal_packages_button_bg_color_wrap" class="e_block_modal_color_round_wrap">'.
						'<div class="e_block_modal_color_round" style="background-color:var(--color-1)" data-color_var="var(--color-1)" data-color="'.$color_1.'"></div>'.
						'<div class="e_block_modal_color_round" style="background-color:var(--color-2)" data-color_var="var(--color-2)" data-color="'.$color_2.'"></div>'.
						'<div class="e_block_modal_color_round" style="background-color:var(--color-3)" data-color_var="var(--color-3)" data-color="'.$color_3.'"></div>'.
					'</div>'.
				'</div>'.
			'</td>'.
		'</tr>'.
	'</table>'.
'</details>'.
e_block_settings_bg($data).
'<details class="dan_accordion">'.
	'<summary>Размер блока</summary>'.
	'<table class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Максимальная ширина</td>'.
			'<td>'.
				'<select id="e_block_modal_max_width" class="dan_input">'.
					'<option value="100" '.$wrap_width_select_100.'>100%</option>'.
					'<option value="1600" '.$wrap_width_select_1600.'>1600px</option>'.
					'<option value="1440" '.$wrap_width_select_1440.'>1440px</option>'.
					'<option value="1280" '.$wrap_width_select_1280.'>1280px</option>'.
					$wrap_width_select_custom_option.
				'</select>'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Внешний отступ (от подложки)</td>'.
			'<td><input id="e_block_modal_margin" class="dan_input" type="number" min="0" max="100" value="'.$content['margin'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Внутренний отступ</td>'.
			'<td><input id="e_block_modal_padding" class="dan_input" type="number" min="0" max="100" value="'.$content['padding'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Радиус скругления</td>'.
			'<td><input id="e_block_modal_border_radius" class="dan_input" type="number" min="0" max="100" value="'.$content['border_radius'].'"></td>'.
		'</tr>'.
	'</table>'.
'</details>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';


echo json_encode(array('answer' => 'success', 'content' => $html, 'style' => $content['style']));
exit;
?>