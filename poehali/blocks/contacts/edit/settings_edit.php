<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/settings_modal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$html =
e_block_settings_bg($data).
e_block_settings_wrap($data).
e_block_settings_size($data).
e_block_settings_font($data).
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';
'<input type="hidden" name="id" value="'.$id.'">';

echo json_encode(array('answer' => 'success', 'style' => $content['style'], 'content' => $html));
exit;

?>