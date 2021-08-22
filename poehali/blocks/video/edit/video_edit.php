<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$video_num = $_POST['video_num'];

$video = $BLOCK_E->getBlock($id)['content']['videos'][$video_num - 1];

$s_1 = $s_2 = '';

if($video['ratio'] == 1) $s_1 = 'selected';
if($video['ratio'] == 2) $s_2 = 'selected';

$content =
'<h2>Редактировать видео c YouTube</h2>'.
'<div class="dan_flex_row e_p_5_20">'.
	'<div class="e_str_left e_flex_basis_100">URL:</div>'.
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h"><input id="e_block_video_modal_url" class="dan_input" name="url" style="width:100%" value="'.$video['url'].'"></div>'.
	'</div>'.
'</div>'.
'<div class="dan_flex_row e_p_5_20">'.
	'<div class="e_str_left e_flex_basis_100">Формат:</div>'.		
	'<div class="e_str_right">'.
		'<div class="e_flex_center_h">'.
			'<select id="e_block_video_modal_ratio" class="dan_input" name="ratio">'.
				'<option value="1" '.$s_1.'>16 x 9</option>'.
				'<option value="2" '.$s_2.'>4 x 3</option>'.
			'</select>'.
		'</div>'.
	'</div>'.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div>'.
		'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">'.
	'</div>'.
	'<div>'.
		'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">'.
	'</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>