<?php
defined('AUTH') or die('Restricted access');

$SITE->headAddFile('/lib/DAN/image_360/image_360.css');
$SITE->headAddFile('/lib/DAN/image_360/image_360.js');
$SITE->headAddFile('/blocks/image_360/frontend/BLOCK.image_360.css');
$SITE->headAddFile('/blocks/image_360/frontend/BLOCK.image_360.js');

function block_image_360($block)
{
	global $SITE;

	switch ($block['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$block['bg_color'].';'; break;
		case 'i': 
			$container_css = 
				'background-image: url(\''.$block['page_r_path'].'/image_360/background/'.$block['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($block['bg_image_size'] == 'cover') 
					$container_css .= 'background-size: cover"';
			break;
		default: $container_css = '';
	}

	$container_css .= $block['font_size'] != 12 ? 'font-size:'.$block['font_size'].'px;' : '';
	$container_css .= $block['line_height'] != 1.2 ? 'line-height:'.$block['line_height'].';' : '';
	$container_css .= $block['color'] != '' ? 'color:'.$block['color'].';' : '';

	$wrap_css = $block['max_width'] && $block['max_width'] != 100 ? 'max-width:'.$block['max_width'].'px;' : '';
	$wrap_css .= $block['margin'] != 0 ? 'margin:'.$block['margin'].'px auto;' : '';

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	if (!empty($wrap_360_style) && $max_width_360 < $max_width/2) {
		$wrap_360_style = 'style="max-width:'.$max_width_360.'px;"';
	} else {
		$wrap_360_style = '';
	}

	$n = round($block['n']/2);
	$m = round($block['m']/2);

	$img_dir = $block['page_r_path'].'/image_360/'.$block['items'][0]['folder'].'/';
	$img_path = $img_dir.$n.'_'.$m.'.jpg';

	$nav_images = '';
	if (count($block['items']) > 0) {
		$num = 1;
		foreach ($block['items'] as $item) {
			$img_nav_dir = $block['page_r_path'].'/image_360/'.$item['folder'].'/';
			$img_nav_path = $img_nav_dir.$n.'_'.$m.'.jpg';
			$active = $num == 1 ? 'active' : '';
			$nav_images .= '<img class="block_image_360_nav_images '.$active.'" src="'.$img_nav_path.'" alt="image 360" data-num="'.$num.'" data-path="'.$img_nav_dir.'">';
			$num++;
		}
		$nav_images = '<div class="block_image_360_nav_images_wrap">'.$nav_images.'</div>';
	}

	return 
	'<div id="block_'.$block['id'].'" class="block" '.$style_container.'>'.
		'<div class="block_image_360_container flex_row" '.$wrap_style.'>'.
			'<div id="block_image_360_text" class="block_image_360_text flex_row">'.
				$block['items'][0]['text'].
			'</div>'.
			'<div class="block_image_360_3d">'.
				'<div id="block_image_360_wrap" class="block_image_360_wrap flex_row relative" '.$wrap_360_style.' data-path="'.$img_dir.'" data-n="'.$block['n'].'" data-m="'.$block['m'].'" data-direction="'.$block['direction'].'">'.
					'<img id="block_image_360_img" src="'.$img_path.'">'.
				'</div>'.
				$nav_images.
			'</div>'.
		'</div>'.		
	'</div>';
}
?>