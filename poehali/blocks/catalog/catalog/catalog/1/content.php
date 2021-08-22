<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/catalog/catalog/catalog/1/style.css');

$catalog = $CATALOG->getCatalog($data['content']['catalog_id']);
$sections = $CATALOG->getSections($data['content']['catalog_id']);

$SITE->setHeadCode('<title>'.$catalog['settings']['tag_title'].'</title>');
$SITE->setHeadCode('<meta name="description" content="'.$catalog['settings']['tag_description'].'" />');

if ($sections) {
	foreach ($sections as $section) {
		if ($section['settings']['image'] == '') {
			$image_html = '<img alt="" class="block_catalog_1_section_image" src="/blocks/catalog/frontend/images/no_photo.png">';
		} else {
			$src = '/files/catalogs/'.$data['content']['catalog_id'].'/sections/'.$section['settings']['image'];
			$image_html = '<img alt="" class="block_catalog_1_section_image" src="'.$src .'">';
		}
		$catalog_html .= 
		'<a href="'.$catalog['url'].'/'.$section['url'].'" class="block_catalog_1_section_wrap">'.
			$image_html.
			'<div class="block_catalog_1_section_text">'.$section['name'].'</div>'.
		'</a>';
	}
}

$catalog_html = 
	'<h1 class="block_catalog_1_title">'.$catalog['name'].'</h1>'.
	'<div class="dan_flex_row_start ">'.$catalog_html.'</div>';