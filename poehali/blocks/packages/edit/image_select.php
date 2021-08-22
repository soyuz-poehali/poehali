<?php
defined('AUTH') or die('Restricted access');

$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;

$content =
'<div class="dan_2_modal_content_center_mobile">'.
'<h2>Выбрать изображение</h2>'.
'<div id="e_block_packages_modal_message"></div>'.
'<table id="e_block_modal_packages_options" class="e_table_admin">'.
	'<tr>'.
		'<td class="e_td_r">Выбрать файл</td>'.
		'<td>'.
			'<input id="e_modal_packages_file" name="file" type="file">'.
		'</td>'.
	'</tr>'.		
'</table>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'<div>'.
'<input type="hidden" name="id" value="'.$id.'">'.
'</div>'
;

echo json_encode(array('answer' => 'success', 'content' => $content));

exit;

?>