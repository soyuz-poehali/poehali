<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/case_2/frontend/1/BLOCK.case_2_1.css');

function block_case_2_1($data)
{
	global $SITE;
	$content = $data['content'];

	// Изображения
	$out = '';
	$num = 1;
	if (count($content['items']) > 0) {
		foreach ($content['items'] as $item) {
			// Изображения
			$images = '';
			foreach ($item['images'] as $image) {
				$count = count($item['images']);
				$src = '/files/pages/'.$SITE->page['id'].'/case_2/'.$image;
				$images .= '<div class="block_case_2_1_hover block_case_2_1_hover_'.$count.'"><div class="block_case_2_1_stroke"></div></div>';
				$images .= '<img class="block_case_2_1_images" src="'.$src.'" alt="">';
			}
			$more = $item['link'] != '' ? '<div class="block_case_2_1_more">Узнать больше</div>' : ''; 
			$images_out = '<div class="block_case_2_1_images_wrap">'.$images.$more.'</div>';

			// Иконки
			$icons = '';
			foreach ($item['icons'] as $icon) {
				$path = $_SERVER['DOCUMENT_ROOT'].'/lib/svg/'.$icon['ico'].'.svg';
				$svg = file_get_contents($path);

				if(!strpos($svg, 'viewBox')) 
					$view_box = 'viewBox="0 0 24 24"';
				else 
					$view_box = '';

				$replace = 'svg class="block_case_2_1_item_svg" style="fill:'.$content['color'].'; '.$view_box;
				$svg_out = str_replace('svg ', $replace, $svg);

				$icons .= 
					'<div class="block_case_2_1_icon_wrap">'.
						'<div class="block_case_2_1_icon_svg">'.$svg_out.'</div>'.
						'<div class="block_case_2_1_icon_text">'.$icon['text'].'</div>'.
					'</div>';
			}
			$icons_out = '<div class="block_case_2_1_icon_container dan_flex_row" style="font-size:'.$content['font_size'].'px;">'.$icons.'</div>';

			$item_content = 
				$images_out.
				'<div>'.
					'<div class="block_case_2_1_text" style="font-size:'.($content['font_size'] + 2).'px;">'.$content['items'][$num-1]['text'].'</div>'.
					$icons_out.
				'</div>';

			if ($item['link'] != '') {
				// Если существует ссылка с блока
				$out .= 
					'<a href="'.$item['link'].'" class="block_case_2_1_item_wrap e_block_item" style="margin:'.$content['padding'].'px;color:'.$content['color'].';background-color:'.$content['items_bg_color'].'">'.
						$item_content.
					'</a>';
			} else {
				// Если нет ссылки с блока
				$out .= 
					'<div class="block_case_2_1_item_wrap e_block_item" style="margin:'.$content['padding'].'px;color:'.$content['color'].';background-color:'.$content['items_bg_color'].'">'.
						$item_content.
					'</div>';
			}

			$num++;	
		}
	}

	return $out;
}

?>