<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;

$package = $BLOCK_E->getBlock($id)['content']['packages'][$num - 1];

$html =
'<h2>Текст кнопки</h2>'.
'<div class="dan_flex_center"><input id="e_block_modal_button_text" class="dan_input" name="button" type="text" value="'.$package['button'].'"></div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>'.
'<input type="hidden" name="id" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>