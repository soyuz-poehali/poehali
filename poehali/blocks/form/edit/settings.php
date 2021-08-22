<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = isset($_POST['style']) ? intval($_POST['style']) : 1;

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

if (!$content['line_height']) 
	$content['line_height'] = 1.2;

$style_selected = array_fill(1, 3, '');
$style_selected[$content['style']] = 'selected';

$wrap_width_select_100 = $wrap_width_select_1600 = $wrap_width_select_1440 = $wrap_width_select_1280 = '';

switch ($content['max_width']) {
	case '100': $wrap_width_select_100 = 'selected'; break;
	case '1600': $wrap_width_select_1600 = 'selected'; break;
	case '1440': $wrap_width_select_1440 = 'selected'; break;
	case '1280': $wrap_width_select_1280 = 'selected'; break;
}

$content =
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>Настройки формы</h2>'.
'<details id="e_block_modal_container" class="dan_accordion">'.
    '<summary>Опции</summary>'.
    '<div><table id="e_block_modal_form_options" class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Тип формы</td>'.
			'<td>'.
				'<select id="e_block_modal_form_style" name="style" class="dan_input">'.
					'<option value="1" '.$style_selected[1].'>Горизонтальная</option>'.
					'<option value="2" '.$style_selected[2].'>Вертикальная, текст справа</option>'.
				'</select>'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Текст кнопки</td>'.
			'<td><input id="e_block_modal_button_text" class="dan_input" type="text" value="'.$content['button_text'].'"></td>'.
		'</tr>'.	
		'<tr>'.
			'<td class="e_td_right">Цвет текста кнопки</td>'.
			'<td><input id="e_block_modal_button_color" class="dan_input" type="color" value="'.$content['button_color'].'"></td>'.
		'</tr>'.		
		'<tr>'.
			'<td class="e_td_right">Цвет фона кнопки</td>'.
			'<td><input id="e_block_modal_button_bg_color" class="dan_input" type="color" value="'.$content['button_bg_color'].'"></td>'.
		'</tr>'.		
	'</table></div>'.
'</details>'.
e_block_settings_bg($data).
e_block_settings_wrap($data).
e_block_settings_size($data).
e_block_settings_font($data).
'<div class="e_modal_wrap_buttons">'.
	'<div>'.
		'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">'.
	'</div>'.
	'<div>'.
		'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">'.
	'</div>'.
'</div>'.
'</div>'
;

// --- СТИЛЬ 1 ---
/*
if ($content['style'] == 1) {
}
*/

echo json_encode(array('answer' => 'success', 'content' => $content, 'style' => $style));

exit;

?>