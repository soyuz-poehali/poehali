<?php
defined('AUTH') or die('Restricted access');

function block_site_portfolio($data)
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
				'background-image: url(\'/files/pages/'.$data['page_id'].'/site_portfolio/background/'.$content['bg_image'].'\');'.
				'background-position: 50% 50%;';
				if ($content['bg_image_size'] == 'cover') 
					$container_css .= 'background-size: cover"';
			break;
		default: $container_css = '';
	}

	$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
	$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';

	$container_css .= $content['font_size'] != 14 ? 'font-size:'.$content['font_size'].'px;' : '';

	$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
	$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

	switch ($content['style']) {
		case 1 : 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/site_portfolio/frontend/1/template.php';
			$site_portfolio_out = block_site_portfolio_1($data);
			break;		
	}

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-type="block" data-block="site_portfolio" data-id="'.$data['id'].'">'.
		'<div id="block_site_portfolio_container_'.$data['id'].'" class="block_site_portfolio_container dan_flex_row relative" '.$wrap_style.'>'.$site_portfolio_out.'</div>'.
	'</div>';
}
?>