<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$template_id = intval($_POST['style_id']);
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['type'] = 'site_portfolio';
$data['status'] = '1';

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/site_portfolio';

if (!is_dir($dir))
	mkdir($dir, 0755, true);

for ($i = 0; $i < 3; $i++) {
	copy($_SERVER['DOCUMENT_ROOT'].'/blocks/site_portfolio/edit/template/1/'.($i + 1).'.jpg', $dir.'/'.($i + 1).'.jpg');
}

$data['content']['style'] = '1';
$data['content']['bg_type'] = 'c';
$data['content']['bg_color'] = '#ffffff';
$data['content']['bg_image'] = '';
$data['content']['bg_image_size'] = 'cover';
$data['content']['margin'] = '40';
$data['content']['padding'] = '10';
$data['content']['max_width'] = '1440';
$data['content']['color'] = '#444444';
$data['content']['font_size'] = '16';
$data['content']['line_height'] = '1.2';
$data['content']['items_border_radius'] = '30';
$data['content']['items_width'] = '300';
$data['content']['items'] = array(
	array('image' => '1.jpg', 'text' => 'Сайт 1', 'link' => '/'),
	array('image' => '2.jpg', 'text' => 'Сайт 2', 'link' => '/'),
	array('image' => '3.jpg', 'text' => 'Сайт 3', 'link' => '/'),
);

$block_id = $BLOCK_E->insertBlock($data);

// Вызываем блок вывода
echo json_encode(array('answer' => 'reload', 'id' => $block_id));

?>