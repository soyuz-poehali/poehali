<?php
defined('AUTH') or die('Restricted access');

function block_scrolling_vertical($data)
{
	global $SITE;
	$content = $data['content'];

	switch ($content['bg_type']) {
		case '1': $container_css = 'background-color: var(--color-1);'; break;
		case '2': $container_css = 'background-color: var(--color-2);'; break;
		case '3': $container_css = 'background-color: var(--color-3);'; break;
		case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
		case 'i': 
			$container_css = 
				'background-image: url(\''.$content['page_r_path'].'/scrolling_vertical/background/'.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($content['bg_image_size'] == 'cover') 
					$container_css .= 'background-size: cover"';
			break;
		default: $container_css = '';
	}

	$container_css .= $content['font_size'] != 12 ? 'font-size:'.$content['font_size'].'px;' : '';
	$container_css .= $content['line_height'] != 1.2 ? 'line-height:'.$content['line_height'].';' : '';
	$container_css .= $content['color'] != '' ? 'color:'.$content['color'].';' : '';

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	switch ($content['style']) {
		case 1 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/scrolling_vertical/frontend/1/template.php';
			$scrolling_vertical_out = block_scrolling_vertical_1($data);
			break;
		case 2 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/scrolling_vertical/frontend/2/template.php';
			$scrolling_vertical_out = block_scrolling_vertical_2($data);
			break;	
	}


	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
		'<div id="block_scrolling_vertical_container_'.$data['id'].'" class="block_scrolling_vertical_container dan_flex_row relative" '.$wrap_style.'>'.$scrolling_vertical_out.'</div>'.
	'</div>';
}
?>