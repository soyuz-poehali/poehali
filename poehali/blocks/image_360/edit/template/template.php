<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/lib/DAN/image_360/image_360.css');
$SITE->setHeadFile('/lib/DAN/image_360/image_360.js');
$SITE->setHeadFile('/blocks/image_360/frontend/BLOCK.image_360.css');
$SITE->setHeadFile('/blocks/image_360/frontend/BLOCK.image_360.js');

function block_image_360($data)
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
				'background-image: url(\'/files/pages/'.$data['page_id'].'/image_360/background/'.$content['bg_image'].'\');'.
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

	$max_width = 100 ? 10000 : $content['max_width']/2;

	if (!empty($content['max_width_360']) && $content['max_width_360'] < $max_width) {
		$wrap_360_style = 'style="max-width:'.$content['max_width_360'].'px;"';
	} else {
		$wrap_360_style = '';
	}

	$n = round($content['n']/2);
	$m = round($content['m']/2);

	$img_dir = '/files/pages/'.$data['page_id'].'/image_360/'.$content['items'][0]['folder'].'/';
	$img_path = $img_dir.$n.'_'.$m.'.jpg';

	$nav_images = '';
	if (count($content['items']) > 0) {
		$num = 1;
		foreach ($content['items'] as $item) {
			$img_nav_dir = '/files/pages/'.$data['page_id'].'/image_360/'.$item['folder'].'/';
			$img_nav_path = $img_nav_dir.$n.'_'.$m.'.jpg';
			$active = $num == 1 ? 'active' : '';
			$nav_images .= '<img class="block_image_360_nav_images '.$active.'" src="'.$img_nav_path.'" alt="image 360" data-num="'.$num.'" data-path="'.$img_nav_dir.'">';
			$num++;
		}
		$nav_images = '<div class="block_image_360_nav_images_wrap">'.$nav_images.'</div>';
	}

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-type="block" data-block="image_360" data-id="'.$data['id'].'">'.
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="item_edit" title="Добавить изображение"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#add"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="text_edit" title="Редактировать текст"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#text"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="items" title="Изображения"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#images"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings_edit" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.			
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="help" title="Помощь"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#help"></use></svg></div>'.	
		'</div>'.
		'<div class="block_image_360_container dan_flex_row" '.$wrap_style.'>'.
			'<div class="block_image_360_text dan_flex_row" data-num="1">'.
				'<div id="block_image_360_text">'.$content['items'][0]['text'].'</div>'.
			'</div>'.
			'<div class="block_image_360_3d">'.
				'<div id="block_image_360_wrap" class="block_image_360_wrap dan_flex_row relative" '.$wrap_360_style.' data-path="'.$img_dir.'" data-n="'.$content['n'].'" data-m="'.$content['m'].'" data-direction="'.$content['direction'].'">'.
					'<img id="block_image_360_img" src="'.$img_path.'">'.
				'</div>'.
				$nav_images.
			'</div>'.
		'</div>'.		
	'</div>';
}


?>