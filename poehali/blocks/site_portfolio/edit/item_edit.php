<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];

$act = $_POST['act'];

if ($act == 'add') {
	$title = 'Добавить';
	$item['text'] = '';
	$item['link'] = '';
} else {
	$num = intval($_POST['num']);
	$title = 'Заменить';
	$item = $content['items'][$num - 1];
}


$content = 
	'<h2>'.$title.' изображение</h2>'.
	'<div id="e_block_image_modal_message" class="e_text_16_b" style="text-align:center;color:#4CAF50;"></div>'.
	'<table class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_right">Новое изображение</td>'.
			'<td><input id="e_block_modal_file" onchange="EDIT.block.shop_profile.file(this.files);" type="file" name="file"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Наименование:</td>'.
			'<td class="e_text_16_b"><input id="e_block_modal_text" type="text" class="dan_input" value="'.$item['text'].'"></td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_right">Ссылка:</td>'.
			'<td class="e_text_16_b"><input id="e_block_modal_link" type="text" class="dan_input" value="'.$item['link'].'"></td>'.
		'</tr>'.
	'</table>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;
