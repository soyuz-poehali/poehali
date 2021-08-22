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
				'<div class="block_packages_2_item e_block_item" style="padding:'.$content['margin'].'px;">'.
					'<div class="block_packages_2_item_wrap" '.$border_radius_style.'>'.
						'<div class="block_packages_2_item_text">'.
							$image_out.					
							'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
							'<a href="'.@$package['link'].'" class="block_packages_2_item_button" style="margin:0 '.$content['padding'].'px '.$content['padding'].'px;color:'.$content['button_color'].';background-color:'.$content['button_bg_color'].';">'.@$package['button'].'</a>'.
						'</div>'.
					'</div>'.
				'</div>';			
		} else if ($content['button'] == 0 && isset($package['link']) && $package['link'] != '') {  // Есть ссылка, но нет кнопки
			$packages .=
				'<div class="block_packages_2_item e_block_item" style="padding:'.$content['margin'].'px;">'.
					'<a href="'.$package['link'].'" class="block_packages_2_item_wrap" '.$border_radius_style.'>'.
						'<div class="block_packages_2_item_text">'.
							$image_out.					
							'<div class="block_packages_item_text_1" '.$item_text_1_style.'>'.$package['text_1'].'</div>'.
						'</div>'.
					'</a>'.
				'</div>';			
		} else {  // Нет ссылки
			$packages .=
				'<div class="block_packages_2_item e_block_item" style="padding:'.$content['margin'].'px;">'.
					'<div class="block_packages_2_item_wrap" '.$border_radius_style.'>'.
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