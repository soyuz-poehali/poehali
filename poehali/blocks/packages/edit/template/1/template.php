<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/packages/frontend/1/BLOCK.packages_1.css');

function block_packages_1($data)
{
	global $SITE;

	$content = $data['content'];
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

	if ($content['padding'] != 0)
		$item_css = 'padding:'.$content['padding'].'px;';

	// --- Items ---
	$packages = '';
	$cpanel_item =
		'<div class="e_item_panel">'.
			'<div class="e_block_panel_ico" data-action="image_select" title="Редактировать изображение"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#image"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="package_text_1_edit" title="Редактировать основной текст"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#edit"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="package_text_2_edit" title="Редактировать дополнительный текст"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#edit_2"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="link_edit" title="Редактировать ссылку"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#link"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="button_edit" title="Текст кнопки"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#button"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить" data-id="'.$data['id'].'" data-target-id="block_packages_container_'.$data['id'].'" data-class="e_block_item" data-f="EDIT.block.packages.update_ordering"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="package_delete" title="Удалить"><svg><use xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.
		'</div>';
	$i = 1;

	foreach ($content['packages'] as $package) {
		$item_text_1_style = 'style="'.$item_css.'background-color:'.$content['text_1_bg'].';"';
		$item_text_2_style = 'style="'.$item_css.'background-color:'.$content['text_2_bg'].';"';
		$border_radius_style = $content['border_radius'] > 0 ? $border_radius_style = 'style="border-radius:'.$content['border_radius'].'px;"' : '';

		$image_out = '';

		$alt_arr = explode(' ', trim(strip_tags($package['text_1'])));
		$alt_arr = array_slice($alt_arr, 0, 5);
		$alt = implode(' ', $alt_arr);

		if (isset($package['image']) && $package['image'] != '')
			$image_out = '<img src="'.'/files/pages/'.$data['page_id'].'/packages/'.$package['image'].'" alt="'.$alt.'">';

		if (isset($package['link']) && $package['link'] != '') {  // Если есть ссылка
			if (isset($content['button']) && $content['button'] == 1) {  // Если есть кнопка
				$packages .=
					'<div class="block_packages_item_1 e_block_item" style="margin:'.$content['margin'].'px;" data-block="packages" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
						'<div class="block_packages_item_1_wrap">'.
							$cpanel_item.
							'<div class="block_packages_item_1_text" '.$border_radius_style.'>'.
								'<div class="block_packages_item_text_1_wrap">'.						
									$image_out.
									'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
								'</div>'.
								'<div class="block_packages_item_text_2_wrap" '.$item_text_2_style.'>'.
									'<div class="block_packages_item_text_2">'.$package['text_2'].'</div>'.
									'<a href="'.@$package['link'].'" class="block_packages_1_item_button" style="color:'.$content['button_color'].';background-color:'.$content['button_bg_color'].';">'.@$package['button'].'</a>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</div>';
			} else {  // Нет кнопки, но есть ссылка
				$packages .=
					'<a href="'.@$package['link'].'" class="block_packages_item_1 e_block_item" style="margin:'.$content['margin'].'px;" data-block="packages" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
						'<div class="block_packages_item_1_wrap">'.
							$cpanel_item.
							'<div class="block_packages_item_1_text" '.$border_radius_style.'>'.
								'<div class="block_packages_item_text_1_wrap">'.						
									$image_out.
									'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
								'</div>'.
								'<div class="block_packages_item_text_2_wrap" '.$item_text_2_style.'>'.
									'<div class="block_packages_item_text_2">'.$package['text_2'].'</div>'.
								'</div>'.
							'</div>'.
						'</div>'.
					'</a>';
			}
		} else {  // Нет ссылки, нет кнопки
			$packages .=
				'<div id="block_packages_container_'.$data['id'].'" class="block_packages_item_1 e_block_item" style="margin:'.$content['margin'].'px;" data-block="packages" data-id="'.$data['id'].'" data-item-num="'.$i.'">'.
					'<div class="block_packages_item_1_wrap">'.
						$cpanel_item.
						'<div class="block_packages_item_1_text" '.$border_radius_style.'>'.
							'<div class="block_packages_item_text_1_wrap">'.						
								$image_out.
								'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
							'</div>'.
							'<div class="block_packages_item_text_2_wrap" '.$item_text_2_style.'>'.
								'<div class="block_packages_item_text_2">'.$package['text_2'].'</div>'.
							'</div>'.
						'</div>'.
					'</div>'.
				'</div>';
		}

		$i++;
	}

	return $packages;
}
?>