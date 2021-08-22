<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/DAN/hexToRGB/hexToRGB.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];

$on = $content['button']['on'] == 1 ? 'checked' : '';
$type_selected['solid'] = $type_selected['border'] = '';
$type_selected[$content['button']['style']] = 'selected';

// Цвета из css
$css_file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/style.css', true);
preg_match("/\--\w*-1:\srgb\((.*)\)/", $css_file, $matches_1);
preg_match("/\--\w*-2:\srgb\((.*)\)/", $css_file, $matches_2);
preg_match("/\--\w*-3:\srgb\((.*)\)/", $css_file, $matches_3);

$color_1 = rgb_to_hex($matches_1[1]);
$color_2 = rgb_to_hex($matches_2[1]);
$color_3 = rgb_to_hex($matches_3[1]);


$content =
'<h2>Кнопкa обратной связи</h2>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100">Вкл./выкл.:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<input id="e_block_modal_on" class="dan_input" type="checkbox" name="button" value="1" '.$on.'>'.
			'<label for="e_block_modal_on"></label>'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100">Текст:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<input id="e_block_modal_text" class="dan_input" type="text" name="text" value="'.$content['button']['text'].'">'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100">Цвет кнопки:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<input id="e_block_modal_bg_color" class="dan_input" type="color" value="'.$content['button']['bg_color'].'">'.
			'<div id="e_block_modal_bg_color_wrap" class="e_block_modal_color_round_wrap">'.
				'<div class="e_block_modal_color_round" style="background-color:var(--color-1)" data-color_var="var(--color-1)" data-color="'.$color_1.'"></div>'.
				'<div class="e_block_modal_color_round" style="background-color:var(--color-2)" data-color_var="var(--color-2)" data-color="'.$color_2.'"></div>'.
				'<div class="e_block_modal_color_round" style="background-color:var(--color-3)" data-color_var="var(--color-3)" data-color="'.$color_3.'"></div>'.
			'</div>'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100">Цвет текста:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<input id="e_block_modal_text_color" class="dan_input" type="color" value="'.$content['button']['text_color'].'">'.
			'<div id="e_block_modal_text_color_wrap" class="e_block_modal_color_round_wrap">'.
				'<div class="e_block_modal_color_round" style="background-color:var(--color-1)" data-color_var="var(--color-1)" data-color="'.$color_1.'"></div>'.
				'<div class="e_block_modal_color_round" style="background-color:var(--color-2)" data-color_var="var(--color-2)" data-color="'.$color_2.'"></div>'.
				'<div class="e_block_modal_color_round" style="background-color:var(--color-3)" data-color_var="var(--color-3)" data-color="'.$color_3.'"></div>'.
			'</div>'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100">Тип:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<select id="e_block_modal_style" class="dan_input">'.
				'<option value="solid" '.$type_selected['solid'].'>Сплошная заливка</option>'.
				'<option value="border" '.$type_selected['border'].'>Обводка</option>'.
			'</select>'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100">Радиус:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<input id="e_block_modal_radius" class="dan_input" type="number" name="link" value="'.$content['button']['radius'].'">'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>