<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/catalog/catalog/item/1/1.css');
$SITE->setHeadFile('/blocks/catalog/catalog/item/1/1.js');

$section_url = $SITE->url_arr[1];
$item_url = $SITE->url_arr[2];

$catalog_id = $data['content']['catalog_id'];

$d = array(
	'catalog_id' => $catalog_id,
	'url' => $section_url,
	'full_request' => true
);
$section = $CATALOG->getSection($d);


$d = array(
	'catalog_id' => $catalog_id,
	'section_id' => $section['id'],
	'url' => $item_url
);
$item = $CATALOG->getItem($d);

$SITE->setHeadCode('<title>'.$item['settings']['tag_title'].'</title>');
$SITE->setHeadCode('<meta name="description" content="'.$item['settings']['tag_description'].'" />');



// ======= ИЗОБРАЖЕНИЯ =======
$image_big_html = '';
$images_more_html = '';
if ($item['images'] != '') {
	$images_arr = explode(';', $item['images']);
	$image_big = str_replace('.', '_.', $images_arr[0]);
	$image_big_html = '<img id="block_catalog_item_image_big" class="block_catalog_item_1_image_big show" src="/files/catalogs/'.$catalog['id'].'/items/'.$image_big.'"  itemprop="image" alt="'.$item['name'].'">';
	
	if (count($images_arr) > 1) {
		$images_more = '';
		foreach ($images_arr as $image) {
			if ($image == $images_arr[0])
				continue;
			$image = str_replace('.', '_.', $image);
			$images_more .= '<img class="block_catalog_item_1_image_more show" src="/files/catalogs/'.$catalog['id'].'/items/'.$image.'" itemprop="image" alt="'.$item['name'].'">';
		}
		$images_more_html = '<div class="block_catalog_item_1_images_more_container">'.$images_more.'</div>';
	}
} else {
	$image_big_html = '<img id="block_catalog_item_image_big" class="block_catalog_item_1_nophoto show" src="/blocks/catalog/frontend/images/no_photo.png" alt="нет изображения">';
}



// ======= ХАРАКТЕРИСТИКИ =======
$d = array(
	'catalog_id' => $catalog_id,
	'item_id' => $item['id'],
	'url' => $item_url
);
$chars = $CATALOG->getItemChars($d);

$char_html = '';
if ($chars) {
	// Перебираем массив и если есть несколько значений характеристики - объединяем в одну и записываем значения через ';'
	$chars_new = [];
	foreach ($chars as $char) {
		if (isset($chars_new[$char['name_id']])) {
			$chars_new[$char['name_id']]['value'] .= ';'.$char['value'];
			$chars_new[$char['name_id']]['options'] .= ';'.$char['options'];
		} else {
			$chars_new[$char['name_id']] = array(
				'name' => $char['name'],
				'value' => $char['value'], 
				'options' => $char['options']
			);
		}
	}

	foreach ($chars_new as $char_name_id => $arr) {
		if ($arr['value'] != '') {
			$value_arr = explode(';', $arr['value']);

			$values_html = '';
			if (count($value_arr) > 1) {  // Количество значений больше единицы
				for ($i = 0; $i < count($value_arr); $i++) {
					$values_html .= '<option>'.$value_arr[$i].'</option>';
				}

				$char_html .= 
				'<tr>'.
					'<td>'.$arr['name'].'</td>'.
					'<td>'.
						'<select name="char['.$char_name_id.']" class="block_catalog_item_1_select">'.
							$values_html.
						'</select>'.
					'</td>'.
				'</tr>';

			} else {
				$char_html .= 
				'<tr>'.
					'<td>'.$arr['name'].'</td>'.
					'<td>'.$value_arr[0].'</td>'.
				'</tr>';			
			}
		}

	}

	if ($char_html != '')
		$char_html = '<table class="block_catalog_item_1_char_table dan_even_odd">'.$char_html.'</table>';
}



// ======= СТИКЕРЫ =======
$stickers_arr = $CATALOG->stickersGet($catalog['id']);

$stickers_html = '';
if ($stickers_arr && count($stickers_arr) && isset($item['settings']['stickers'])) {
	foreach ($stickers_arr as $sticker) {
		if (in_array($sticker['id'], $item['settings']['stickers'])) {
			$stickers_html .= '<div class="block_catalog_item_1_sticker" style="color:'.$sticker['color'].
			'; background-color:'.$sticker['bg_color'].';">'.$sticker['name'].'</div>';
		}
	}
	$stickers_html =
	'<div class="block_catalog_item_1_image_stickers_container">'.
		$stickers_html.
	'</div>';
}



// ======= СОПУТСТВУЮЩИЕ ТОВАРЫ =======
$d = array(
	'catalog_id' => $catalog_id,
	'item_id' => $item['id'],
);
$related_arr = $CATALOG->getRelatedItems($d);

$related_html = '';

if ($related_arr) {
	foreach ($related_arr as $related) {
		if ($related['images'] != '') {
			$images_arr = explode(';', $related['images']);
			$related_image = '<img class="block_catalog_item_1_related_image" src="/files/catalogs/'.$catalog['id'].'/items/'.$images_arr[0].'" alt="'.$related['name'].'">';
		} else {
			$related_image = '<img class="block_catalog_item_1_related_nophoto" src="/blocks/catalog/frontend/images/no_photo.png" alt="нет изображения">';
		}

		$related_html .= 
		'<a href="/'.$catalog['url'].'/'.$related['section_url'].'/'.$related['url'].'" class="block_catalog_item_1_related_wrap">'.
			$related_image.
			'<div class="block_catalog_item_1_related_name">'.$related['name'].'</div>'.
		'</a>';
	}

	$related_html = 
		'<div class="block_catalog_item_1_related_container">'.
			'<div class="block_catalog_item_1_related_title">Сопутствующие товары:</div>'.
			'<div class=" dan_flex_row_start">'.
				$related_html.
			'</div>'.
		'</div>';
}



// ======= ЦЕНА =======
$price_normal_html = $price_sale_html = '';
$price_sale = false;
$price_sale_strikeout_class = ''; // Класс зачёркнутой цены (обычной), если есть цена со скидкой

// --- Идентификатор цены со скидкой ---
$price_sale_type_id = $CATALOG->priceGetTypeIdByName(array(
	'catalog_id' => $catalog_id, 
	'name' => 'Цена со скидкой'
));

// --- Цена со скидкой ---
if ($price_sale_type_id) {
	$price_sale = $CATALOG->priceGetValueByItemId(array(
		'catalog_id' => $catalog_id,
		'price_type_id' => $price_sale_type_id,
		'item_id' => $item['id']
	));

	if ($price_sale && $price_sale > 0 && $price_sale < $item['price']) {
		$price_sale_strikeout_class = 'strikeout';
		$price_sale_html =
		'<div class="block_catalog_item_1_price_sale_wrap">'.
			'<span id="block_catalog_item_1_price_sale" class="block_catalog_item_1_price_sale" data-price_sale="'.$price_sale.'">'.number_format($price_sale, 0, '', ' ').'</span>'.
			'<span class="block_catalog_item_1_currency">'.$catalog['settings']['shop_currency'].'</span>'.
		'</div>';
	}
}

// --- Обычная цена ---
if (intval($item['price']) > 0) {
	$price_normal_html =
	'<div class="block_catalog_item_1_price_wrap '.$price_sale_strikeout_class.'">'.
		'<span id="block_catalog_item_1_price" class="block_catalog_item_1_price" data-price="'.$item['price'].'" itemprop="price">'.number_format($item['price'], 0, '', ' ').'</span>'.
		'<span class="block_catalog_item_1_currency" itemprop="priceCurrency">'.$catalog['settings']['shop_currency'].'</span>'.
	'</div>';
}

// --- Цена html ---
if ($price_normal_html != '') {
	$price_html =
	'<div class="block_catalog_item_1_price_container">'.
		$price_normal_html.$price_sale_html.
	'</div>';
}

$catalog_html .= 
// '<form class="block_catalog_item_1_form" method="POST" action="/'.$catalog['url'].'/basket/add">'.
	'<div id="block_catalog_item_container" itemscope itemtype="http://schema.org/Product">'.
		'<h1 class="block_catalog_item_1_title" itemprop="name">'.$item['name'].'</h1>'.
		'<div class="w1440 dan_flex_row">'.
			'<div class="block_catalog_item_1_left_container">'.
				'<div class="block_catalog_item_1_image_container">'.
					$stickers_html.
					$image_big_html.
				'</div>'.
				$images_more_html.
			'</div>'.
			'<div class="block_catalog_item_1_right_container">'.
				'<div class="block_catalog_item_1_info_container dan_flex_row">'.
					$char_html.
					'<div class="block_catalog_item_1_text" itemprop="description">'.$item['text'].'</div>'.
				'</div>'.
				'<div class="block_catalog_item_1_price_container dan_flex_row">'.
					$price_html.
					'<div class="block_catalog_item_1_button_wrap">'.
						'<input id="block_catalog_item_button" class="block_catalog_item_1_button" value="Добавить в корзину" type="submit" data-item_id="'.$item['id'].'" data-image_id="block_catalog_item_image_big">'.
					'</div>'.
				'</div>'.
			'</div>'.
		'</div>'.
			$related_html.
		'<input id="item_id" type="hidden" value="'.$item['id'].'" name="item_id" />'.
	'</div>';
// '</form>';
