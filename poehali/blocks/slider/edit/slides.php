<?php
defined('AUTH') or die('Restricted access');
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);

$content = $BLOCK_E->getBlock($id)['content'];

// ДИРЕКТОРИЯ
$dir = '/files/pages/'.$page_id.'/slider/';

$out = '';
$i = 1;
foreach ($content['slides'] as $slide) {
	if (mb_strlen($slide['text_1']) > 25)
		$slide['text_1'] = mb_substr($slide['text_1'], 0, 25).'...';

	$out .= 
		'<table class="e_table_admin e_block_modal_item" data-block="slider" data-id="'.$id.'" data-item-num="'.$i.'"><tbody>'.
			'<tr>'.
				'<td ><img src="'.$dir.$slide['file'].'"></td>'.
				'<td class="e_td_text">'.$slide['text_1'].'</td>'.
				'<td class="e_td_ico"><svg class="drag_drop_ico" data-id="'.$id.'" data-target-id="block_modal_target" data-class="e_block_modal_item" data-direction="y"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></td>'.
				'<td class="e_td_ico"><svg class="e_block_panel_ico" data-action="slide_edit"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></td>'.
				'<td class="e_td_ico"><svg class="e_block_panel_ico" data-action="slide_delete"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></td>'.
			'</tr>'.
		'</tbody></table>';
	$i++;
}

$content =
	'<h2>Настройки слайдера</h2>'.
	'<div id="block_modal_target" class="e_block_modal">'.
		$out.
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