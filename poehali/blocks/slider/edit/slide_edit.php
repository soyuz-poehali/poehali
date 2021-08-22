<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$slide_num = isset($_POST['slide_num']) ? intval($_POST['slide_num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];

// Расчёт размеров слайдера для первого типа
if ($content['style'] == 1) {
	$width = $content['max_width'] == 100 ? 1920 : $content['max_width'];
	$w = $width - 2 * $content['margin'] - 2 * $content['padding'];
	$h = round($w * $content['ratio']);
}

if ($content['style'] == 2) {
	$w = 1920;
	$h = round($w * $content['ratio']);
}

if ($SITE->url_arr[3] == 'slide_add') {
	$title = 'Добавить слайд';
	$text_1 = '';
	$text_2 = '';
	$link = '';
}

if ($SITE->url_arr[3] == 'slide_edit') {
	$title = 'Редактировать слайд';
	
	$slide = $content['slides'][$slide_num - 1];
	$text_1 = $slide['text_1'];
	$text_2 = $slide['text_2'];
	$link = $slide['link'];
}

$content =
'<div class="dan_2_modal_content_center_mobile">'.
	'<h2>'.$title.'</h2>'.
	'<div class="e_block_modal_recommendations">Рекомендуемые размеры изображения: <span class="e_text_16_b"><b id="e_block_modal_slider_w">'.$w.'</b> х <b id="e_block_modal_slider_h">'.$h.'</b> px.</span></div>'.
	'<table id="e_block_modal_slider_options" class="e_table_admin">'.
		'<tr>'.
			'<td class="e_td_r">Выбрать файл</td>'.
			'<td>'.
				'<input id="e_block_modal_slider_file" name="file" type="file">'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Текст 1</td>'.
			'<td>'.
				'<input id="e_block_modal_slider_text_1" class="dan_input" type="text" value="'.$text_1.'">'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Текст 2</td>'.
			'<td>'.
				'<input id="e_block_modal_slider_text_2" class="dan_input" type="text" value="'.$text_2.'">'.
			'</td>'.
		'</tr>'.
		'<tr>'.
			'<td class="e_td_r">Ссылка</td>'.
			'<td>'.
				'<input id="e_block_modal_slider_link" class="dan_input" type="text" value="'.$link.'">'.
			'</td>'.
		'</tr>'.		
	'</table>'.
	'<div class="e_modal_wrap_buttons">'.
		'<div>'.
			'<input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить">'.
		'</div>'.
		'<div>'.
			'<input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить">'.
		'</div>'.
	'</div>'.
	'<input type="hidden" name="id" value="'.$id.'">'.
'</div>'
;

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>