<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$html = '';
$i = 0;
foreach ($content['items'] as $item) {
	$text = mb_strlen($item['text']) > 25 ? mb_substr($item['text'], 0, 25).'...' : '';

	$n = round($content['n']/2);
	$m = round($content['m']/2);
	$img_dir = '/files/pages/'.$data['page_id'].'/image_360/'.$content['items'][$i]['folder'].'/';
	$img_path = $img_dir.$n.'_'.$m.'.jpg';

	$html .= 
	'<div class="e_block_modal_item dan_flex_row p_0" data-block="image_360" data-id="'.$id.'" data-item_num="'.($i + 1).'">'.
		'<div><img src="'.$img_path.'"></div>'.
		'<div class="e_block_modal_item_name">'.$item['text'].'</div>'.
		'<div class="e_block_modal_item_ico_container">'.
		//	'<div class="e_block_modal_item_ico">'.
		//		'<svg class="e_block_panel_ico e_block_panel_items_ico" data-action="item_edit">'.
		//			'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#text"></use>'.
		//		'</svg>'.
		//	'</div>'.
			'<div class="e_block_modal_item_ico">'.
				'<svg class="drag_drop_ico" data-id="'.$id.'" data-target-id="dan_2_modal_content" data-class="e_block_modal_item" data-direction="y" data-f="EDIT.block.image_360.items_ordering">'.
					'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use>'.
				'</svg>'.
			'</div>'.
			'<div class="e_block_modal_item_ico">'.
				'<svg class="e_block_panel_ico" data-action="item_delete">'.
					'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use>'.
				'</svg>'.
			'</div>'.
		'</div>'.
	'</div>';

	$i++;	
}

$html .=
	'<div class="e_modal_wrap_buttons">'.
		'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить порядок"></div>'.
		'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
	'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>