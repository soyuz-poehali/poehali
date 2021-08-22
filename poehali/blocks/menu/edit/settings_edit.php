<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

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
	
$sticky_checked = $content['sticky'] == 1 ? 'checked' : '';

$template_select_1 = $template_select_999 = '';
if (isset($content['template']) && $content['template'] == 999)
	$template_select_999 = 'selected';
else
	$template_select_1 = 'selected';


if (is_file($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/template/999/template.php'))
	$template_999_html = '<option value="999" '.$template_select_999.'>Индивидуальный</option>';
else 
	$template_999_html = '';

$html =
'<h2>Настройки меню</h2>'.
e_block_settings_bg($data).
'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Размеры, положение, шаблон</summary>'.
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
			'<td class="e_td_right">Отступ</td>'.
			'<td><input id="e_block_modal_padding" class="dan_input" type="number" min="0" max="100" value="'.$content['padding'].'"></td>'.
		'</tr>'.
		'<tr id="e_block_modal_font_tr">'.
			'<td class="e_td_right">Прилипающее меню</td>'.
			'<td><div class="e_flex_center_h"><input id="e_block_modal_sticky" class="dan_input" type="checkbox" value="" '.$sticky_checked.'><label for="e_block_modal_sticky"></label></div></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Шаблон</td>'.
			'<td>'.
				'<select id="e_block_modal_template" class="dan_input">'.
					'<option value="1" '.$template_select_1.'>Стандартный</option>'.
					$template_999_html.
				'</select>'.
			'</td>'.
		'</tr>'.
	'</table>'.
'</details>'.
'<details id="e_block_modal_container" class="dan_accordion">'.
	'<summary>Шрифт</summary>'.
	'<table class="e_table_admin">'.
		'<tr id="e_block_modal_font_tr">'.
			'<td class="e_td_right">Размер, цвет шрифта</td>'.
			'<td>'.
				'<div class="e_flex_center_h">'.
					'<input id="e_block_modal_font_size" class="dan_input" type="number" min="10" max="48" value="'.$content['font_size'].'">&nbsp;'.
					'<input  id="e_block_modal_font_color" class="dan_input" type="color" value="'.$content['color'].'">'.
				'</div>'.
			'</td>'.
		'</tr>'.
		'<tr id="e_block_modal_font_tr">'.
			'<td class="e_td_right">Цвет активного меню</td>'.
			'<td><div class="e_flex_center_h"><input  id="e_block_modal_font_color_active" class="dan_input" type="color" value="'.$content['color_active'].'"></div></td>'.
		'</tr>'.
	'</table>'.
'</details>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';	

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>