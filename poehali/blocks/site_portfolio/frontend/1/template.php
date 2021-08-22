<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/site_portfolio/frontend/1/BLOCK.site_portfolio_1.css');
$SITE->setHeadFile('/blocks/site_portfolio/frontend/1/BLOCK.site_portfolio_1.js');

function block_site_portfolio_1($data)
{
	global $SITE;

	$content = $data['content'];

	$items_style = '';
	$items_style .= $content['items_width'] == 300 ? 'width:'.$content['items_width'].'px;' : '';
	$items_style .= $content['items_border_radius'] == 0 ? '' : 'border-radius:'.$content['items_border_radius'].'px;';
	$items_style = '' ? '' : 'style="'.$items_style.'"';
	
	$text_color = $content['color'] != '#000000' ? 'style="color:'.$content['color'].'"' : '';

	// Изображения
	$out = '';
	$num = 1;
	if (count($content['items']) > 0) {
		foreach ($content['items'] as $item) {
			if ($item['link'] != '') {
				$image = 
				'<a class="block_site_profile_item_wrap_a" target="_blank" href="'.$item['link'].'">'.
					'<img class="block_site_profile_item_image" src="/files/pages/'.$data['page_id'].'/site_portfolio/'.$item['image'].'" alt="'.$item['text'].'">'.
				'</a>';
				$text = '<a target="_blank" href="'.$item['link'].'">'.$item['text'].'</a>';
			} else {
				$image = 
				'<span class="block_site_profile_item_wrap_a">'.
					'<img class="block_site_profile_item_image" src="/files/pages/'.$data['page_id'].'/site_portfolio/'.$item['image'].'" alt="'.$item['text'].'">'.
				'</span>';
				$text = '<span>'.$item['text'].'</span>';
			}

			$out .= 
				'<div class="block_site_profile_item_wrap e_block_item" '.$items_style.'>'.
					$image.
					'<div class="block_site_profile_item_text" '.$text_color.'>'.$text.'</div>'.
				'</div>';

			$num++;	
		}
	}

	return $out;
}

?>