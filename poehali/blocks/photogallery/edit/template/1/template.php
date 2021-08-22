<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/DAN/hexToRGB/hexToRGB.php';

$SITE->setHeadFile('/blocks/photogallery/frontend/1/BLOCK.photogallery_1.css');

function block_photogallery_1($data)
{
	global $SITE;
	$b = $data['content'];

	$dir = '/files/pages/'.$SITE->page['id'].'/photogallery/';

	// --- Items ---
	$item_wrap_css = '';
	if($b['padding'] != 0) $item_wrap_css .= 'padding:'.$b['padding'].'px;';

	$photos = '';
	$i = 1;

	foreach ($b['photos'] as $photo) {
		$cpanel_item =
			'<div class="e_item_panel">'.
				'<div class="e_block_panel_ico" data-action="photo_edit" title="Редактировать"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
				'<div class="drag_drop_ico" title="Перетащить" data-id="'.$data['id'].'" data-target-id="block_photogallery_container_'.$data['id'].'" data-class="block_photogallery_photo_1_wrap" data-f="EDIT.block.photogallery.update_ordering"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
				'<div class="e_block_panel_ico" data-action="photo_delete" title="Удалить"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
			'</div>';

		if ($photo['link'] == '') {
			$item_wrap_style = $item_wrap_css != '' ? 'style="'.$item_wrap_css.'"' : '';
			$photos .=
				'<div '.$item_wrap_style.' class="block_photogallery_photo_1_wrap e_block_item" data-block="photogallery" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
					$cpanel_item.
					'<img class="block_photogallery_photo_1_image" src="'.$dir.$photo['file'].'" alt="'.$photo['text_1'].'">'.
					'<div class="block_photogallery_photo_1_title" style="font-size:'.$b['title_size'].'px;">'.$photo['text_1'].'</div>'.
				'</div>';
		} else {
			$item_wrap_css .= 'color:'.$b['color'].';';
			$item_wrap_style = 'style="'.$item_wrap_css.'"';
			$photos .=
				'<a href="'.$photo['link'].'" '.$item_wrap_style.' class="block_photogallery_photo_1_wrap e_block_item" data-block="photogallery" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
					$cpanel_item.
					'<img class="block_photogallery_photo_1_image" src="'.$dir.$photo['file'].'" alt="'.$photo['text_1'].'">'.
					'<div class="block_photogallery_photo_1_title" style="font-size:'.$b['title_size'].'px;">'.$photo['text_1'].'</div>'.
				'</a>';
		}

		$i++;
	}

	return $photos;
}
?>