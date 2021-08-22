<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/functions/bg_image.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$content = $data['content'];


$page_id = intval($_POST['p']);
$content['max_width'] = intval($_POST['max_width']);
$content['padding'] = intval($_POST['padding']);
$content['bg_type'] = $_POST['bg_type'];
$content['bg_color'] = $_POST['bg_color'];
$content['bg_image_size'] = isset($_POST['bg_image_size']) ? $_POST['bg_image_size'] : '';
$content['font_size'] = $_POST['font_size'];
$content['color'] = $_POST['color'];
$content['sticky'] = isset($_POST['sticky']) ? 1 : false;
$content['font_size'] = isset($_POST['font_size']) ? intval($_POST['font_size']) : false;
$content['color'] = strip_tags($_POST['color']);
$content['color_active'] = strip_tags($_POST['color_active']);
$content['template'] = intval($_POST['template']);

$bg_type_arr = array('', '1', '2', '3', 'c', 'i');

if (!in_array($content['bg_type'], $bg_type_arr)) {
	$SITE->errLog('Некорректный тип фона: '.$bg_type.', block_id => '.$id);
	exit;
}

// Фон - изображение
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/0/menu';
if ($content['bg_type'] == 'i') {
	$bg_image = e_bg_image($dir, $content['bg_image']);  # $content['bg_image'] - слева новый контент, справа - старый
	if ($bg_image)
		$content['bg_image'] = $bg_image;
} else {
	$content['bg_image'] = '';
	// Удаляем старый файл
	$file_old = $dir.'/background/'.$content['bg_image'];
	if (is_file($file_old))
		unlink($file_old);
}



// --- ЗАПИСЫВАЕМ СТИЛИ В ФАЙЛ style.css ---
// Находим область, заключённую в разделители
// Начальный разделитель: /* --- MENU--- */
// Конечный разделитель: /* --- /menu --- */
// Всё что между ними - стиль для меню

$style_css_file = $_SERVER['DOCUMENT_ROOT'].'/templates/style.css';

// Создаём файл, если он отсутствует
if (!is_file($style_css_file))
	file_put_contents($style_css_file, '');  // PHP_EOL - Корректный символ конца строки, используемый на данной платформе.


$lines = file($style_css_file);  // Читаем содержимое файла в массив

// Находим индекс начала и индекс конца стилей меню
$num_start = $num_end = 0;
foreach ($lines as $num => $line) {
    if (strstr($line, '--- MENU ---'))
    	$num_start = $num;

    if (strstr($line, '--- /menu ---'))
    	$num_end = $num;
}


$block_menu_css = $block_menu_class = '';  // CSS класса 'block_menu'
$block_menu_wrap_css = $block_menu_wrap_class = '';  // CSS класса 'block_menu_wrap'


// --- block_menu ---
// Sticky
if ($content['sticky'] == 1) {
	$block_menu_class .= 
	"	position: sticky; \n".
	"	top: 0; \n";
}

// Стили для фона и подложки
switch ($content['bg_type']) {
	case '1': $block_menu_class .= "	background-color: var(--color-1); \n"; break;
	case '2': $block_menu_class .= "	background-color: var(--color-2); \n"; break;
	case '3': $block_menu_class .= "	background-color: var(--color-3); \n"; break;
	case 'c': $block_menu_class .= "	background-color: ".$content['bg_color']."; \n"; break;
	case 'i':
		$dir = '/files/pages/0/menu/background/';
		$block_menu_class .=
			"	background-image: url('".$dir.$content['bg_image']."'); \n".
			"	background-position: 50% 50%; \n";
			if ($content['bg_image_size'] == 'cover') 
				$block_menu_class .= "	background-size: cover; \n";
		break;
}

// Вывод класса 'block_menu'
if ($block_menu_class != '') {
	$block_menu_css = 
	".block_menu { \n".
		$block_menu_class.
	"} \n";
}


// --- block_menu_wrap ---
$block_menu_wrap_class .= $content['max_width'] && $content['max_width'] != 100 ? '	max-width: '.$content['max_width']."px; \n" : '';
$block_menu_wrap_class .= $content['padding'] != 0 ? '	padding: '.$content['padding']."px 0px; \n" : '';

// Вывод класса 'block_menu_wrap'
if ($block_menu_wrap_class != '') {
	$block_menu_wrap_css = 
	".block_menu_wrap { \n".
		$block_menu_wrap_class.
	"} \n";
}


// CSS контент
$css_menu_content = 
'
/* --- MENU --- */
'.$block_menu_css.'
'.$block_menu_wrap_css.'
.block_menu_top_wrap {
	--menu-top-color: '.$content['color'].';
	--menu-top-color-active: '.$content['color_active'].';
}
/* --- /menu --- */
';


if ($num_start == 0 || $num_end == 0) {
	// Не найден блок css для меню
	file_put_contents($style_css_file, $css_menu_content, FILE_APPEND); 
} else {
	$arr_1 = array_slice($lines, 0, $num_start-1);
	$arr_2 = array_slice($lines, $num_end+1);

	$css_content = implode('', $arr_1);
	$css_content .= $css_menu_content;
	$css_content .= implode('', $arr_2);

	file_put_contents($style_css_file, $css_content);
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>