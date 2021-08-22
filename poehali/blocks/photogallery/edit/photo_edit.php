<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$photo_num = isset($_POST['photo_num']) ? intval($_POST['photo_num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

if ($SITE->url_arr[3] == 'photo_add') {
	$title = 'Добавить фото';
	$text_1 = '';
	$text_2 = '';
	$link = '';
}

if ($SITE->url_arr[3] == 'photo_edit') {
	$title = 'Редактировать фото';
	
	$photo = $content['photos'][$photo_num - 1];
	$text_1 = $photo['text_1'];
	$text_2 = $photo['text_2'];
	$link = $photo['link'];
}

$text_2 =  preg_replace('/\<br(\s*)?\/?\>/i', "", $text_2);

$content =
'<div class="dan_2_modal_content_center_mobile">'.
	'<h2>'.$title.'</h2>'.
	'<div id="e_block_photogallery_modal_message"></div>'.
	'<table id="e_block_modal_photogallery_options" class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_r">Выбрать файл</td>'.
			'<td>'.
				'<input id="e_block_modal_photogallery_file" name="file" type="file">'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Текст 1</td>'.
			'<td>'.
				'<input id="e_block_modal_photogallery_text_1" class="dan_input" style="width:100%" type="text" value="'.$text_1.'">'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Текст 2</td>'.
			'<td>'.
				'<textarea id="e_block_modal_photogallery_text_2" class="dan_input" rows="5" style="width:100%">'.$text_2.'</textarea>'.
			'</td>'.
		'</tr>'.	
	'</table>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>'.
	'<input type="hidden" name="id" value="'.$id.'">'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

exit;

?>