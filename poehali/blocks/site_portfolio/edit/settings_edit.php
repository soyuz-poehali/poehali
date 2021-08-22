<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

// Размер блока
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

// Размер шрифта
$font_s_selected = $font_m_selected = '';
if ($content['font_size'] == 'var(--font-size)') {
	$font_s_selected = 'selected';
	$content['font_size'] = $SITE->settings->font_size;
} else
	$font_m_selected = 'selected';


$html =
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>Настройки блока</h2>'.
e_block_settings_bg($data).
	'<details id="e_block_modal_container" class="dan_accordion">'.
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
				'<td class="e_td_right">Внешний отступ (от края блока)</td>'.
				'<td><input id="e_block_modal_margin" class="dan_input" type="number" min="0" max="100" value="'.$content['margin'].'"></td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Ширина элементов</td>'.
				'<td><input id="e_block_modal_items_width" class="dan_input" type="number" min="200" max="600" value="'.$content['items_width'].'"></td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Радиус скругления углов</td>'.
				'<td><input id="e_block_modal_items_border_radius" class="dan_input" type="number" min="0" max="100" value="'.$content['items_border_radius'].'"></td>'.
			'</tr>'.
		'</table>'.
	'</details>'.
	'<details id="e_block_modal_container" class="dan_accordion">'.
		'<summary>Шрифт</summary>'.
		'<table class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Шрифт</td>'.
				'<td>'.
					'<select id="e_block_modal_font_select" class="dan_input">'.
						'<option value="s" '.$font_s_selected.'>Из настроек сайта</option>'.
						'<option value="m" '.$font_m_selected.'>Свой размер и цвет</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr id="e_block_modal_font_tr">'.
				'<td class="e_td_right">Размер, цвет основного шрифта</td>'.
				'<td><div class="e_flex_center_h"><input id="e_block_modal_font_size" class="dan_input" type="number" min="10" max="48" value="'.$content['font_size'].'">&nbsp;<input  id="e_block_modal_font_color" class="dan_input" type="color" value="'.$content['color'].'"></div></td>'.
			'</tr>'.
		'</table>'.
	'</details>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>