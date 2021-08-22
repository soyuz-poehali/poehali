<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/virtual_tour/frontend/BLOCK.virtual_tour.css');
$SITE->setHeadFile('/blocks/virtual_tour/frontend/BLOCK.virtual_tour.js');
$SITE->setHeadFile('/blocks/virtual_tour/frontend/three.js');

function block_virtual_tour($data)
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
				'background-image: url(\'/files/pages/'.$SITE->page_id.'/virtual_tour/background/'.$content['bg_image'].'\');'.
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

	$image = '/files/pages/'.$data['page_id'].'/virtual_tour/'.$content['items'][0]['image'];

	return 
	'<div id="block_'.$data['id'].'" class="block" '.$style_container.' data-type="block" data-block="virtual_tour" data-id="'.$data['id'].'">'.
		'<div class="e_block_panel">'.
			'<div class="e_block_panel_ico" data-action="item_edit" title="Добавить изображение"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#add"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="items" title="Изображения"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#images"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="settings_edit" title="Настройки"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#gear"></use></svg></div>'.
			'<div class="drag_drop_ico" title="Перетащить блок" data-id="'.$data['id'].'" data-class="block" data-direction="y" data-f="EDIT.block.update_ordering"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#cursor_24"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="del" title="Удалить"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#delete"></use></svg></div>'.			
			'<div class="e_block_panel_ico" data-action="up" title="Переместить выше"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#up"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="down" title="Переместить ниже"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#down"></use></svg></div>'.
			'<div class="e_block_panel_ico" data-action="help" title="Помощь"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/edit/blocks/template/e_sprite.svg#help"></use></svg></div>'.	
		'</div>'.
		'<div id="block_virtual_tour_container" class="block_virtual_tour_container flex_row relative" '.$wrap_style.'>'.
			'<div class="block_virtual_tour_text">'.$content['items'][0]['text'].'</div>'.
			'<div id="block_virtual_tour_image" class="block_virtual_image" data-image="'.$image.'"></div>'.
		'</div>'.
	'</div>';
}
?>