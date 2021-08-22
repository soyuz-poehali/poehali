<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$out = '';
$i = 0;
foreach ($content['items'] as $item) {
	if (mb_strlen($item['text']) > 25)
		$item['text'] = mb_substr($item['text'], 0, 25).'...';

	if (count($content['items']) > 1) {
		$ico_dnd_out = 
		'<div class="e_block_modal_item_ico">'.
			'<svg class="drag_drop_ico" data-id="'.$id.'" data-target-id="block_modal_target" data-class="e_block_modal_item" data-direction="y" data-f="EDIT.block.virtual_tour.items_ordering"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg>'.
		'</div>';
		$ico_del_out =
		'<div class="e_block_modal_item_ico">'.
			'<svg class="e_block_panel_ico" data-action="item_delete"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg>'.
		'</div>';
	} else {
		$ico_dnd_out = $ico_del_out = '';
	}

	$out .= 
		'<div class="dan_flex_row e_block_modal_item"  data-block="virtual_tour" data-block="virtual_tour" data-id="'.$id.'" data-item_num="'.($i + 1).'">'.
			'<img src="/files/pages/'.$data['page_id'].'/virtual_tour/'.$content['items'][$i]['image'].'">'.
			'<div class="e_block_modal_item_name">'.$item['text'].'</div>'.
			$ico_dnd_out.
			'<div class="e_block_modal_item_ico">'.
				'<svg class="e_block_panel_ico" data-action="item_edit"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg>'.
			'</div>'.
			$ico_del_out.
		'</div>';
	$i++;
}

$html =
	'<h2>Сцены панорамы</h2>'.
	'<div id="block_modal_target" class="e_block_modal">'.
		$out.
	'</div>'.
	'<div id="e_modal_wrap_buttons" class="e_modal_wrap_buttons" style="display:none;">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить порядок"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;
?>