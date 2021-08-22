<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];

$html =
'<h2>Настройки</h2>'.
'<details class="dan_accordion">'.
	'<summary>Опции</summary>'.
	'<div>'.
		'<div class="dan_flex_row e_p_5_20">'.
			'<div class="e_str_left e_flex_basis_150">Размер</div>'.			
			'<div class="e_str_right">'.
					'<div class="e_flex_center_h"><input id="e_block_modal_callback_size" type="range" min="50" max="100" step="5" value="'.$content['size'].'"><div class="e_modal_range_out"><span id="e_block_modal_callback_size_out">'.$content['size'].'</span> px</div></div>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row e_p_5_20">'.
			'<div class="e_str_left e_flex_basis_150">Положение снизу</div>'.			
			'<div class="e_str_right">'.
					'<div class="e_flex_center_h"><input id="e_block_modal_callback_bottom" type="range" min="10" max="100" step="5" value="'.$content['bottom'].'"><div class="e_modal_range_out"><span id="e_block_modal_callback_bottom_out">'.$content['bottom'].'</span> px</div></div>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row e_p_5_20">'.
			'<div class="e_str_left e_flex_basis_150">Положение слева</div>'.			
			'<div class="e_str_right">'.
					'<div class="e_flex_center_h"><input id="e_block_modal_callback_right" type="range" min="10" max="100" step="5" value="'.$content['right'].'"><div class="e_modal_range_out"><span id="e_block_modal_callback_right_out">'.$content['right'].'</span> px</div></div>'.
			'</div>'.
		'</div>'.
		'<div class="dan_flex_row e_p_5_20">'.
			'<div class="e_str_left e_flex_basis_150">Цвет</div>'.			
			'<div class="e_str_right">'.
					'<div class="e_flex_center_h"><input id="e_block_modal_callback_color" class="input" type="color" value="'.$content['color'].'"></div>'.
			'</div>'.
		'</div>'.
	'</div>'.
'</details>'.	
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';	


echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>