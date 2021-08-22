<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$style_1_selected = $style_2_selected = '';
switch ($content['style']) {
	case '1':
		$style_1_selected = 'selected';
		break;

	case '2':
		$style_2_selected = 'selected';
		break;
}

$html =
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>Настройки блока</h2>'.
'<details class="dan_accordion">'.
	'<summary>Опции</summary>'.
	'<table class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Тип</td>'.
			'<td>'.
				'<select id="e_block_modal_style_select" class="dan_input">'.
					'<option value="1" '.$style_1_selected.'>Текст над видео</option>'.
					'<option value="2" '.$style_2_selected.'>Текст слева от видео</option>'.
				'</select>'.
			'</td>'.
		'</tr>'.
	'</table>'.
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
'<input type="hidden" name="id" value="'.$id.'">'.
'</div>'
;

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>