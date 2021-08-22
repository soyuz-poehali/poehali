<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/packages/frontend/2/BLOCK.packages_2.css');

function block_packages_2($block)
{
	global $SITE;

	$content = $block['content'];

	$item_style	= '';
	$item_css = '';

	if ($content['wrap_bg_color']) {
		if ($content['wrap_bg_opacity'] == 1) {
			$item_css .= 'background-color:'.$content['wrap_bg_color'].';padding:20px;';
		} else {
			// RGB
			list($R, $G, $B) = sscanf($content['wrap_bg_color'], "#%02x%02x%02x");
			$item_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$content['wrap_bg_opacity'].');padding:20px;';
		}
	}

	if ($content['padding'] != 0) {
		$item_css = 'padding:'.$content['padding'].'px;';
	}

	// --- Items ---
	$packages = '';
	$cpanel_item =
		'<div class="e_item_panel">'.
			'<div class="e_block_panel_ico" data-action="image_select" title="Редактировать изображение"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#image"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="package_text_1_edit" title="Редактировать основной текст"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="link_edit" title="Редактировать ссылку"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#link"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="button_edit" title="Текст кнопки"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#button"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить" data-id="'.$block['id'].'" data-target-id="block_packages_container_'.$block['id'].'" data-class="e_block_item" data-f="EDIT.block.packages.update_ordering"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="package_delete" title="Удалить"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
		'</div>';
	$i = 1;

	foreach ($content['packages'] as $package) {
		$item_text_1_style = 'style="'.$item_css.'background-color:'.$content['text_1_bg'].';"';
		$border_radius_style = $content['border_radius'] > 0 ? $border_radius_style = 'style="border-radius:'.$content['border_radius'].'px;"' : '';

		$image_out = '';

		$alt_arr = explode(' ', trim(strip_tags($package['text_1'])));
		$alt_arr = array_slice($alt_arr, 0, 5);
		$alt = implode(' ', $alt_arr);

		if (isset($package['image']) && $package['image'] != '') {
			$image_out = '<img src="/files/pages/'.$SITE->page['id'].'/packages/'.$package['image'].'" alt="'.$alt.'">';
		}

		if ($content['button'] == 1) {
			$packages .=
				'<div class="block_packages_2_item e_block_item" style="padding:'.$content['margin'].'px;" data-block="packages" data-id="'.$block['id'].'" data-item-num="'.$i.'">'.
					'<div class="block_packages_2_item_wrap" '.$border_radius_style.'>'.
						$cpanel_item.
						'<div class="block_packages_2_item_text">'.
							$image_out.					
							'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
							'<a href="'.@$package['link'].'" class="block_packages_2_item_button" style="margin:0 '.$content['padding'].'px '.$content['padding'].'px;color:'.$content['button_color'].';background-color:'.$content['button_bg_color'].';">'.@$package['button'].'</a>'.
						'</div>'.
					'</div>'.
				'</div>';			
		} else if ($content['button'] == 0 && isset($package['link']) && $package['link'] != '') {  // Есть ссылка, но нет кнопки
			$packages .=
				'<div class="block_packages_2_item e_block_item" style="padding:'.$content['margin'].'px;" data-block="packages" data-id="'.$block['id'].'" data-item-num="'.$i.'">'.
					'<a href="'.$package['link'].'" class="block_packages_2_item_wrap" '.$border_radius_style.'>'.
						$cpanel_item.
						'<div class="block_packages_2_item_text">'.
							$image_out.					
							'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
						'</div>'.
					'</a>'.
				'</div>';			
		} else {  // Нет ссылки
			$packages .=
				'<div class="block_packages_2_item e_block_item" style="padding:'.$content['margin'].'px;" data-block="packages" data-id="'.$block['id'].'" data-item-num="'.$i.'">'.
					'<div class="block_packages_2_item_wrap" '.$border_radius_style.'>'.
						$cpanel_item.
						'<div class="block_packages_2_item_text">'.
							$image_out.					
							'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
						'</div>'.
					'</div>'.
				'</div>';
		}

		$i++;
	}

	return $packages;
}
?>