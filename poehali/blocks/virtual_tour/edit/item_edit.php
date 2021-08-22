<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

if ($num) {
	$title = 'Редактировать сцену';
	$item = $content['items'][$num-1];
} else {
	$title = 'Добавить сцену';
	$item['text'] = '';
}

$html =
'<h2>'.$title.'</h2>'.
'<table id="e_block_modal_slider_options" class="e_table_admin">'.
	'<tr>'.
		'<td class="e_td_r">Выбрать файл</td>'.
		'<td>'.
			'<input id="e_modal_file" name="file" type="file">'.
		'</td>'.
	'</tr>'.
	'<tr>'.
		'<td class="e_td_r">Текст</td>'.
		'<td>'.
			'<input id="e_modal_text" class="dan_input" type="text" value="'.$item['text'].'">'.
		'</td>'.
	'</tr>'.		
'</table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>'.
'<input type="hidden" name="id" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>