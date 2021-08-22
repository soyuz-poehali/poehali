<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/link_page_block.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;

$package = $BLOCK_E->getBlock($id)['content']['packages'][$num - 1];

$pb_arr  = link_page_block($package['link']);

$html = 
$pb_arr['pages'].
'<div>'.
	'<h2>Редактировать ссылку</h2>'.
	$pb_arr['link'].
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'<div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));

exit;

?>