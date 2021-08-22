<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$style = isset($_POST['style']) ? intval($_POST['style']) : false;

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$dots_checked = $content['dots'] == 1 ? 'checked' : '';

$effect_selected = array_fill(1, 4, '');
$effect_selected[$content['effect']] = 'selected';

if ($style) 
	$data['content']['style'] = $style;

if (!isset($content['line_height']))
	$content['line_height'] = 1;

// СТИЛЬ 1
if ($data['content']['style'] == 1) {
	$html =
	'<div class="dan_2_modal_content_center_mobile">'.
	'<h2>Настройки слайдера</h2>'.
	'<div class="e_block_modal_accordion_body e_h_450 expand">'.
		'<h3 class="e_block_modal_accordion_head expand">Опции</h3>'.
		'<table id="e_block_modal_slider_options" class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Тип</td>'.
				'<td>'.
					'<select id="e_block_modal_slider_style" name="style" class="dan_input">'.
						'<option selected value="1">С текстом на тёмной полосе</option>'.
						'<option value="2">С затемнением</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Точки навигации</td>'.
				'<td>'.
					'<input id="e_block_modal_slider_dots" class="dan_input" name="dots" type="checkbox" value="1" '.$dots_checked.'><label for="e_block_modal_slider_dots"></label>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Эффект</td>'.
				'<td>'.
					'<select id="e_block_modal_slider_effect" name="effect" class="dan_input">'.
						'<option '.$effect_selected[1].' value="1">Появление</option>'.
						'<option '.$effect_selected[2].' value="2">Сверху</option>'.
						'<option '.$effect_selected[3].' value="3">Слева</option>'.
						'<option '.$effect_selected[4].' value="4">Справа</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Высота / ширина</td>'.
				'<td>'.
					'<div class="e_flex_center_h"><input id="e_block_modal_slider_ratio" onmousemove="EDIT.block.slider.ratio();" type="range" name="ratio" min="20" max="60" step="1" style="width:120px;" value="'.($content['ratio'] * 100).'"><div class="e_modal_range_out"><span id="e_block_modal_slider_ratio_out">'.($content['ratio'] * 100).'</span> %</div></div>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Интервал отображения</td>'.
				'<td>'.
					'<div class="e_flex_center_h"><input id="e_block_modal_slider_interval" onmousemove="EDIT.block.slider.interval();" type="range" name="interval" min="2" max="10" step="1" style="width:120px;" value="'.$content['interval'].'"><div class="e_modal_range_out"><span id="e_block_modal_slider_interval_out">'.$content['interval'].'</span> сек.</div></div>'.
				'</td>'.
			'</tr>'.		
		'</table>'.
	'</div>'.
	'<hr class="e_hr">'.
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
}


// СТИЛЬ 2
if ($data['content']['style'] == 2) {
	$text_1_selected = array_fill (1, 6, '');
	$text_2_selected = array_fill (1, 6, '');

	$text_1_selected[$content['text_1_size']] = 'selected';
	$text_2_selected[$content['text_2_size']] = 'selected';

	$html =
	'<div class="dan_2_modal_content_center_mobile">'.
	'<h2>Настройки слайдера</h2>'.
	'<div class="e_block_modal_accordion_body e_h_350 expand">'.
		'<h3 class="e_block_modal_accordion_head expand">Опции</h3>'.
		'<table id="e_block_modal_slider_options" class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Тип</td>'.
				'<td>'.
					'<select id="e_block_modal_slider_style" name="style" class="dan_input">'.
						'<option value="1">С текстом на тёмной полосе</option>'.
						'<option selected value="2">С затемнением</option>'.
					'</select>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Точки навигации</td>'.
				'<td>'.
					'<input id="e_block_modal_slider_dots" class="dan_input" name="dots" type="checkbox" value="1" '.$dots_checked.'><label for="e_block_modal_slider_dots"></label>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Высота / ширина</td>'.
				'<td>'.
					'<div class="e_flex_center_h"><input id="e_block_modal_slider_ratio" onmousemove="EDIT.block.slider.ratio();" type="range" name="ratio" min="20" max="60" step="1" style="width:120px;" value="'.($content['ratio'] * 100).'"><div class="e_modal_range_out"><span id="e_block_modal_slider_ratio_out">'.($content['ratio'] * 100).'</span> %</div></div>'.
				'</td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Интервал отображения</td>'.
				'<td>'.
					'<div class="e_flex_center_h"><input id="e_block_modal_slider_interval" onmousemove="EDIT.block.slider.interval();" type="range" name="interval" min="3" max="30" step="1" style="width:120px;" value="'.$content['interval'].'"><div class="e_modal_range_out"><span id="e_block_modal_slider_interval_out">'.$content['interval'].'</span> сек.</div></div>'.
				'</td>'.
			'</tr>'.		
		'</table>'.
	'</div>'.
	'<hr class="e_hr">'.
	'<div class="e_block_modal_accordion_body e_h_200">'.
	'<h3 class="e_block_modal_accordion_head">Вуаль</h3>'.
		'<table class="e_table_admin">'.
			'<tr>'.
				'<td class="e_td_right">Цвет</td>'.
				'<td><input id="e_block_modal_slider_fog_color" class="dan_input" type="color" value="'.$content['fog_color'].'"></td>'.
			'</tr>'.
			'<tr>'.
				'<td class="e_td_right">Непрозрачность</td>'.
				'<td><div class="e_flex_center_h"><input id="e_block_modal_slider_fog_opacity" type="range" min="10" max="100" step="5" value="'.($content['fog_opacity'] * 100).'"><div class="e_modal_range_out"><span id="e_block_modal_slider_fog_opacity_out">'.($content['fog_opacity'] * 100).'</span>%</div></div></td>'.
			'</tr>'.
		'</table>'.
	'</div>'.
	'<hr class="e_hr">'.
	'<div class="e_block_modal_accordion_body e_h_350">'.
	'<h3 class="e_block_modal_accordion_head">Шрифт</h3>'.
		'<table class="e_table_admin">'.
			'<tr id="e_block_modal_font_tr">'.
				'<td class="e_td_right">Цвет</td>'.
				'<td><div class="e_flex_center_h"><input id="e_block_modal_font_color" class="dan_input" type="color" value="'.$content['color'].'"></div></td>'.
			'</tr>'.			
			'<tr>'.
				'<td class="e_td_right">Размер шрифта 1</td>'.
				'<td><div class="e_flex_center_h">'.
					'<select id="e_block_modal_slider_text_1_size" class="dan_input">'.
						'<option value="6" '.$text_1_selected[6].'>Огромный</option>'.
						'<option value="5" '.$text_1_selected[5].'>Очень крупный</option>'.
						'<option value="4" '.$text_1_selected[4].'>Крупный</option>'.
						'<option value="3" '.$text_1_selected[3].'>Средний</option>'.
						'<option value="2" '.$text_1_selected[2].'>Мелкий</option>'.
						'<option value="1" '.$text_1_selected[1].'>Очень мелкий</option>'.
					'</select>'.
				'</div></td>'.
			'</tr>'.
			'<tr id="e_block_modal_font_tr">'.
				'<td class="e_td_right">Размер шрифта 2</td>'.
				'<td><div class="e_flex_center_h">'.
					'<select id="e_block_modal_slider_text_2_size" class="dan_input">'.
						'<option value="6" '.$text_2_selected[6].'>Огромный</option>'.
						'<option value="5" '.$text_2_selected[5].'>Очень крупный</option>'.
						'<option value="4" '.$text_2_selected[4].'>Крупный</option>'.
						'<option value="3" '.$text_2_selected[3].'>Средний</option>'.
						'<option value="2" '.$text_2_selected[2].'>Мелкий</option>'.
						'<option value="1" '.$text_2_selected[1].'>Очень мелкий</option>'.
					'</select>'.
				'</div></td>'.
			'</tr>'.
		'</table>'.
	'</div>'.
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
}

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>