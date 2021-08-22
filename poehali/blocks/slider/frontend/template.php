<?php
defined('AUTH') or die('Restricted access');

function block_slider($data)
{
	global $SITE;

	$dir = '/files/pages/'.$SITE->page['id'].'/slider/';
	$slides = '';
	$i = 0;


	// --- СТИЛЬ 1 ---
	$slider_out = '';

	if ($data['content']['style'] == 1) {
		switch ($data['content']['bg_type']) {
			case '1': $container_css = 'background-color: var(--color-1);'; break;
			case '2': $container_css = 'background-color: var(--color-2);'; break;
			case '3': $container_css = 'background-color: var(--color-3);'; break;
			case 'c': $container_css = 'background-color: '.$data['content']['bg_color'].';'; break;
			case 'i':
				$container_css =
					'background-image: url(\''.$dir.'/background/'.$$data['content']['bg_image'].'\');'.
					'background-position: 50% 50%;';
					if ($data['content']['bg_image_size'] == 'cover')
						$container_css .= 'background-size: cover;';
				break;
			default: $container_css = '';
		}


		if ($data['content']['font_size'] == 'var(--font-size)')	
			$container_css .= 'font-size:'.$data['content']['font_size'].';';
		else 
			$container_css .= 'font-size:'.$data['content']['font_size'].'px;';

		$container_css .= $data['content']['color'] ? 'color:'.$data['content']['color'].';' : '';
		$container_css .= !$data['content']['line_height'] || $data['content']['line_height'] == 1.2 ? '' : 'line-height:'.$data['content']['line_height'].';';

		$wrap_css = $data['content']['max_width'] && $data['content']['max_width'] != 100 ? 'max-width:'.$data['content']['max_width'].'px;' : '';
		$wrap_css .= $data['content']['margin'] != 0 ? 'margin:'.$data['content']['margin'].'px auto;' : '';
		$wrap_css .= $data['content']['padding'] != 0 ? 'padding:'.$data['content']['padding'].'px;' : '';

		if (isset($data['content']['wrap_bg_opacity'])) {
			if ($data['content']['wrap_bg_opacity'] == 1) {
				$wrap_css .= $data['content']['wrap_bg_color'] ? 'background-color:'.$data['content']['wrap_bg_color'].';' : '';
			} else {
				list($R, $G, $B) = sscanf($data['content']['wrap_bg_color'], "#%02x%02x%02x");  // RGB
				$wrap_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$data['content']['wrap_bg_opacity'].');';
			}
		}

		$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
		$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';
	
		$SITE->setHeadFile('/blocks/slider/frontend/1/BLOCK.slider_1.css');
		$SITE->setHeadFile('/blocks/slider/frontend/1/BLOCK.slider_1.js');

		foreach ($data['content']['slides'] as $slide) {
			$slides .= 'var s = new Object(); s.file = "'.$dir.$slide['file'].'"; s.text = "'.$slide['text_1'].'"; s.link = "'.$slide['link'].'"; slider_'.$data['id'].'.slides['.$i.'] = s;';
			$i++;
		}

		$slider_out .= '<script>';
		$slider_out .= 'var slider_'.$data['id'].' = new BLOCK.slider_1("'.$data['id'].'");';

		if ($data['content']['ratio'] != 0.3) 
			$slider_out .= 'slider_'.$data['id'].'.ratio = '.$data['content']['ratio'].';';

		if ($data['content']['dots'] == 0) 
			$slider_out .= 'slider_'.$data['id'].'.dots = 0;';

		$slider_out .= $slides;
		$slider_out .= 'slider_'.$data['id'].'.play();';
		$slider_out .= '</script>';
		
		$out =
		'<div id="block_'.$data['id'].'" class="block" '.$style_container.'>'.
			'<div '.$wrap_style.'><div id="block_slider_container_'.$data['id'].'" class="block_slide_1_container">'.$slider_out.'</div></div>'.
		'</div>';
	}

	// --- СТИЛЬ 2 ---
	if ($data['content']['style'] == 2) {
		$SITE->setHeadFile('/blocks/slider/frontend/2/BLOCK.slider_2.css');
		$SITE->setHeadFile('/blocks/slider/frontend/2/BLOCK.slider_2.js');

		$container_css = '';
		$container_css .= $data['content']['color'] ? 'color:'.$data['content']['color'].';' : '';
		$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';

		foreach ($data['content']['slides'] as $slide) {
			$slides .= 'var s = new Object(); s.f = "'.$dir.$slide['file'].'"; s.text_1 = "'.$slide['text_1'].'"; s.text_2 = "'.$slide['text_2'].'";  s.link = "'.$slide['link'].'"; slider_'.$data['id'].'.slides['.$i.'] = s;';
			$i++;
		}

		$slider_out .= '<script>';
		$slider_out .= 'var slider_'.$data['id'].' = new BLOCK.slider_2("'.$data['id'].'");';

		if ($data['content']['ratio'] != 0.3) 
			$slider_out .= 'slider_'.$data['id'].'.ratio = '.$data['content']['ratio'].';';

		if($data['content']['dots'] == 0) 
			$slider_out .= 'slider_'.$data['id'].'.dots = 0;';

		$slider_out .= 'slider_'.$data['id'].'.interval = '.($data['content']['interval'] * 1000).';';
		$slider_out .= 'slider_'.$data['id'].'.color = "'.$data['content']['color'].'";';
		$slider_out .= 'slider_'.$data['id'].'.fog_color = "'.$data['content']['fog_color'].'";';
		$slider_out .= 'slider_'.$data['id'].'.fog_opacity = '.$data['content']['fog_opacity'].';';
		$slider_out .= 'slider_'.$data['id'].'.text_1_size = '.$data['content']['text_1_size'].';';
		$slider_out .= 'slider_'.$data['id'].'.text_2_size = '.$data['content']['text_2_size'].';';
		$slider_out .= $slides;
		$slider_out .= 'slider_'.$data['id'].'.play();';
		$slider_out .= '</script>';

		$out =
		'<div id="block_'.$data['id'].'" class="block" '.$style_container.'">'.
			'<div id="block_slider_container_'.$data['id'].'" class="block_slide_2_container">'.$slider_out.'</div>'.
		'</div>';		
	}


	return $out;
}
?>