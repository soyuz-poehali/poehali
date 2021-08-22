<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];

$num = intval($_POST['num']);
$images = $content['items'][($num-1)]['images'];

$images_out = '';
$image_num = 1;
foreach ($images as $image) {
	$images_out .= 
	'<div class="e_block_case_2_modal_images" data-block="case_2" data-id="'.$id.'" data-item-num="'.$num.'" data-image-num="'.$image_num.'">'.
		'<img src="/files/pages/'.$page_id.'/case_2/'.$image.'" alt="">'.
		'<div class="dan_flex_row">'.
			'<svg class="e_block_case_2_modal_svg e_block_panel_ico" data-action="item_image_edit">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use>'.
			'</svg>'.
			'<svg class="e_block_case_2_modal_svg drag_drop_ico" data-id="'.$id.'" data-target-id="e_block_case_2_modal_images_container" data-class="e_block_case_2_modal_images" data-f="EDIT.block.case_2.item_images_ordering">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use>'.
			'</svg>'.
			'<svg class="e_block_case_2_modal_svg e_block_panel_ico" data-action="item_image_delete" data-id="'.$id.'" data-item-num="'.$num.'" data-image-num="'.$image_num.'">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use>'.
			'</svg>'.
		'</div>'.
	'</div>';
	$image_num++;	
}

$icons = $content['items'][($num-1)]['icons'];
$icons_out = '';
$icon_num = 1;
foreach ($icons as $icon) {
	$path = $_SERVER['DOCUMENT_ROOT'].'/lib/svg/'.$icon['ico'].'.svg';
	$svg = file_get_contents($path);

	if(!strpos($svg, 'viewBox')) 
		$view_box = 'viewBox="0 0 24 24"';
	else 
		$view_box = '';

	$replace = 'svg style="fill:'.$content['color'].'; '.$view_box;
	$svg_out = str_replace('svg ', $replace, $svg);
	$icons_out .= 
	'<div class="e_block_case_2_modal_icons" data-block="case_2" data-id="'.$id.'" data-item-num="'.$num.'" data-icon-num="'.$icon_num.'">'.
		'<div class="e_block_case_2_modal_icon">'.$svg_out.'</div>'.
		'<div class="e_block_case_2_modal_text">'.$icon['text'].'</div>'.
		'<div class="dan_flex_row">'.
			'<svg class="e_block_case_2_modal_svg e_block_panel_ico" data-action="item_icon_svg_edit">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use>'.
			'</svg>'.
			'<svg class="e_block_case_2_modal_svg e_block_panel_ico" data-action="item_icon_text">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#text"></use>'.
			'</svg>'.
			'<svg class="e_block_case_2_modal_svg drag_drop_ico" data-id="'.$id.'" data-target-id="e_block_case_2_modal_icons_container" data-class="e_block_case_2_modal_icons" data-f="EDIT.block.case_2.item_icons_ordering">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use>'.
			'</svg>'.
			'<svg class="e_block_case_2_modal_svg e_block_panel_ico" data-action="item_icon_delete">'.
				'<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use>'.
			'</svg>'.
		'</div>'.
	'</div>';
	$icon_num++;
}


$html =
'<h2>Редактируемые области</h2>'.
'<div id="e_block_case_2_modal_image_add" class="e_block_case_2_modal_add">Добавить изображение</div>'.
'<div id="e_block_case_2_modal_images_container" class="e_block_case_2_modal_container dan_flex_row">'.$images_out.'</div>'.
'<div id="e_block_case_2_modal_icon_add" class="e_block_case_2_modal_add">Добавить иконку</div>'.
'<div id="e_block_case_2_modal_icons_container" class="e_block_case_2_modal_container dan_flex_row">'.$icons_out.'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100 e_flex_center_h">Текст:</div>'.
	'<div class="e_str_right">'.
		'<input id="e_block_case_2_modal_item_text" class="dan_input" value="'.$content['items'][$num-1]['text'].'">'.
	'</div>'.
'</div>'.
'<div class="dan_modal_wrap">'.
	'<div class="e_str_left e_flex_basis_100 e_flex_center_h">Ссылка:</div>'.
	'<div class="e_str_right">'.
		'<input id="e_block_case_2_modal_item_link" class="dan_input" value="'.$content['items'][$num-1]['link'].'">'.
	'</div>'.
'</div>'.
'<div class="e_modal_wrap_buttons">'.
	'<div><input id="e_modal_submit" class="e_modal_button_submit" type="submit" name="submit" value="Сохранить"></div>'.
	'<div><input id="e_modal_cancel" class="e_modal_button_cancel" type="submit" name="cancel" value="Отменить"></div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $html));
exit;

?>