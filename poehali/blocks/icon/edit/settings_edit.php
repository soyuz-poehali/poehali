<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

if (!$content['line_height']) 
	$content['line_height'] = 1.2;

$style_selected = array_fill(1, 3, '');
$style_selected[$content['style']] = 'selected';

$html =
'<h2>Настройки блока</h2>'.
'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Опции</summary>'.
	'<table id="e_block_modal_icon_options" class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Тип</td>'.
			'<td>'.
				'<select id="e_block_modal_icon_style" name="style" class="dan_input">'.
					'<option selected value="1" '.$style_selected[1].'>Круглые иконки</option>'.
					'<option value="2" '.$style_selected[2].'>Квадратные</option>'.
					'<option value="3" '.$style_selected[3].'>Без обводки</option>'.
				'</select>'.
			'</td>'.
			'<tr>'.
				'<td class="e_td_right">Размер иконки</td>'.
				'<td>'.
					'<div class="e_flex_center_h">'.
						'<input id="e_block_modal_icon_size" type="range" min="50" max="150" step="10" value="'.$content['icon_size'].'">'.
						'<div class="e_modal_range_out"><span id="e_block_modal_icon_size_out">'.$content['icon_size'].'</span></div>'.
					'</div>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Цвет иконок</td>'.
				'<td>'.
					'<input id="e_block_modal_icon_color" class="dan_input" type="color" value="'.$content['icon_color'].'">'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Цвет шрифта</td>'.
				'<td>'.
					'<input id="e_block_modal_font_color" class="dan_input" type="color" value="'.$content['color'].'">'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Размер шрифта заголовка</td>'.
				'<td>'.
					'<input id="e_block_modal_title_size" class="dan_input" type="number" min="16" max="36" value="'.$content['title_size'].'">'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Размер шрифта дополнительного текста</td>'.
				'<td>'.
					'<input id="e_block_modal_font_size" class="dan_input" type="number" min="10" max="36" value="'.$content['font_size'].'">'.
				'</td>'.
			'</tr>'.
		'</tr>'.		
	'</table>'.
'</details>'.
e_block_settings_bg($data).
e_block_settings_wrap($data).
e_block_settings_size($data).
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html, 'style' => $content['style']));

exit;

?>