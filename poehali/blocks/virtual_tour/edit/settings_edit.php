<?php
defined('AUTH') or die('Restricted access');
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
} else
	$font_m_selected = 'selected';


$html =
'<h2>Настройки блока</h2>'.
e_block_settings_bg($data).
'<div class="e_block_modal_accordion_body e_h_300">'.
	'<h3 class="e_block_modal_accordion_head">Размер блока</h3>'.
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
	'</table>'.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;
?>