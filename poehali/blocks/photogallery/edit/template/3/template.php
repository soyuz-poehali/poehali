<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/DAN/hexToRGB/hexToRGB.php';

$SITE->setHeadFile('/blocks/photogallery/frontend/3/BLOCK.photogallery_3.css');

function block_photogallery_3($data)
{
	global $SITE;

	$b = $data['content'];
	$dir = '/files/pages/'.$SITE->page['id'].'/photogallery/';

	// --- Items ---
	$item_wrap_css = '';
	if ($b['padding'] != 0) 
		$item_wrap_css .= 'padding:'.$b['padding'].'px;';

	$photos = '';
	$i = 1;

	foreach ($b['photos'] as $photo) {
		$cpanel_items =
			'<div class="e_item_panel">'.
				'<div class="e_block_panel_ico" data-action="photo_edit" title="Редактировать"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
				'<div class="drag_drop_ico" title="Перетащить" data-id="'.$data['id'].'" data-target-id="block_photogallery_container_'.$data['id'].'" data-class="block_photogallery_photo_3_wrap" data-f="EDIT.block.photogallery.update_ordering"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
				'<div class="e_block_panel_ico" data-action="photo_delete" title="Удалить"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'</div>';

		$item_bg_style = hex_bg($b['fog_color'], $b['fog_opacity']);
		$title_bg_style = hex_bg($b['fog_color'], 0.38);

		$hover =
			'<div class="block_photogallery_photo_3_hover" style="'.$item_bg_style.'">'.
				'<div class="block_photogallery_photo_3_title" style="'.$title_bg_style.'font-size:'.$b['title_size'].'px;">'.$photo['text_1'].'</div>'.
				'<div class="block_photogallery_photo_3_text">'.$photo['text_2'].'</div>'.
			'</div>';

		if ($photo['link'] == '') {
			$item_wrap_style = $item_wrap_css != '' ? 'style="'.$item_wrap_css.'"' : '';
			$photos .=
				'<div class="block_photogallery_photo_3_wrap e_block_item" '.$item_wrap_style.' data-block="photogallery" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
					$cpanel_items.
					'<div class="block_photogallery_photo_3_w">'.
						'<img class="block_photogallery_photo_3_image" src="'.$dir.$photo['file'].'" alt="'.$photo['text_1'].'">'.
						$hover.
					'</div>'.
				'</div>';
		} else {
			$item_wrap_css .= 'color:'.$b['color'].';';
			$item_wrap_style = 'style="'.$item_wrap_css.'"';
			$photos .=
				'<a href="'.$photo['link'].'" class="block_photogallery_photo_3_wrap e_block_item" '.$item_wrap_style.' data-block="photogallery" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
					$cpanel_items.
					'<div class="block_photogallery_photo_3_w">'.
						'<img class="block_photogallery_photo_3_img" src="'.$dir.$photo['file'].'" alt="'.$photo['text_1'].'">'.
						$hover.
					'</div>'.
				'</a>';
		}

		$i++;
	}

	return $photos;
}

?>