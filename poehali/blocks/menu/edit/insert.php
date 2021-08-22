<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = '0';
$data['ordering'] = '0';
$data['type'] = 'menu';
$data['status'] = '1';

$data['content']['sticky'] = '1';
$data['content']['max_width'] = '1440';
$data['content']['padding'] = '20';
$data['content']['font_size'] = '16';
$data['content']['line_height'] = '1.2';
$data['content']['color'] = '#444444';
$data['content']['color_active'] = '#ff0000';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = 'cover';
$data['content']['wrap_bg_color'] = '#ffffff';
$data['content']['wrap_bg_opacity'] = '1';
$data['content']['template'] = '1';

$data['content']['logo'] = array(
	'pub' => 0,
	'logo' => ''
);

$data['content']['logo_text'] = '';

$data['content']['phone_1'] = array(
	'pub' => 1,
	'phone' => '+7 (777) 777 77 77',
	'color' => '#000000',
	'whatsapp' => 1,
	'viber' => 1
);

$data['content']['phone_2'] = array(
	'pub' => 0,
	'phone' => '+8 (888) 888 88 88',
	'color' => '#000000',
	'whatsapp' => 0,
	'viber' => 0
);

$data['content']['sn'] = array(
	'pub' => 0,
	'vk' => '',
	'fb' => '',
	'ok' => '',
	'instagramm' => '',
	'youtube' => '',
);

$data['content']['basket'] = array(
	'pub' => 0,
	'catalog_id' => 0,
);

$data['content']['right_text'] = '';

// Проверка размещения блока на странице
if ($BLOCK_E->getBlockCount($data) > 0) {
	echo json_encode(array('answer' => 'message', 'text' => 'Меню уже размещено!'));
	exit;
}

// Рабочая директория меню
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/0/menu';
if(!is_dir($dir)) 
	mkdir($dir, 0755, true);

// Копируем файл
$source_path = $_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/template/1/logo.png';
copy($source_path, $dir.'/logo.png');

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;

?>