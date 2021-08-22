<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/catalog/catalog/section/1/style.css');

$section_url = $SITE->url_arr[1];

$d = array(
	'catalog_id' => $data['content']['catalog_id'],
	'url' => $section_url,
	'full_request' => true
);

$section = $CATALOG->getSection($d);

$SITE->setHeadCode('<title>'.$section['settings']['tag_title'].'</title>');
$SITE->setHeadCode('<meta name="description" content="'.$section['settings']['tag_description'].'" />');

$d = array(
	'catalog_id' => $data['content']['catalog_id'],
	'section_id' => $section['id']
);

$stickers_arr = $CATALOG->stickersGet($data['content']['catalog_id']);
$items = $CATALOG->getItems($d);

if ($items) {
	foreach ($items as $item) {
		// ------- СТИКЕРЫ -------
		$item_settings = unserialize($item['settings']);
		$item_stickers = isset($item_settings['stickers']) ? $item_settings['stickers'] : [];

		$stickers_html = '';
		if ($stickers_arr && count($stickers_arr) > 0) {
			foreach ($stickers_arr as $sticker) {
				if (in_array($sticker['id'], $item_stickers)) {
					$stickers_html .= '<div class="block_catalog_section_1_sticker" style="color:'.$sticker['color'].
					'; background-color:'.$sticker['bg_color'].';">'.$sticker['name'].'</div>';
				}
			}
			$stickers_html = '<div class="block_catalog_section_1_stickers_container">'.$stickers_html.'</div>';
		}		

		if ($item['images'] == '') {
			$image_html = '<img class="block_catalog_section_1_item_image" src="/blocks/catalog/frontend/images/no_photo.png">';
		} else {
			$image_arr = explode(';', $item['images']);
			$src = '/files/catalogs/'.$data['content']['catalog_id'].'/items/'.$image_arr[0];
			$image_html = '<img class="block_catalog_section_1_item_image" src="'.$src .'">';
		}
	
		$price_html = '';
		if (intval($item['price']) > 0) {
			$price = number_format($item['price'], 0, '', ' ');
			$price_html = '<div class="block_catalog_section_1_item_price">'.$price.'<span> '.$catalog['settings']['shop_currency'].'</span></div>';
		}
		
		$d = array('catalog_id' => $data['content']['catalog_id'], 'item_id' => $item['id'], 'limit' => 3);
		$chars = $CATALOG->getItemChars($d);
		
		$chars_html = '';
		if ($chars) {
			foreach ($chars as $char) {
				$chars_html .= 
				'<tr>'.
					'<td>'.$char['name'].', '.$char['unit'].'</td>'.
					'<td class="block_catalog_section_1_item_char_td_2">'.$char['value'].'</td>'.
				'</tr>';
			}
			$chars_html = '<table class="block_catalog_section_1_item_char_table">'.$chars_html.'</table>';
		}

		$catalog_html .= 
		'<a href="/'.$catalog['url'].'/'.$section_url.'/'.$item['url'].'" class="block_catalog_section_1_item_wrap">'.
			$stickers_html.
			$image_html.
			'<div class="block_catalog_section_1_item_name">'.$item['name'].'</div>'.
			$price_html.
			$chars_html.
		'</a>';
	}
}

$catalog_html = 
	'<h1 class="block_catalog_1_title">'.$catalog['name'].'</h1>'.
	'<div class="dan_flex_row_start ">'.$catalog_html.'</div>';