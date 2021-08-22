<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$video_url = trim(strip_tags($_POST['video_url']));
$text = trim(htmlspecialchars(strip_tags($_POST['text'])));
$ratio = intval($_POST['ratio']);

$video_url = str_replace('watch?v=', 'embed/', $video_url); // Для работы с ссылкой из адреса
$video_url = str_replace('youtu.be', 'youtube.com/embed', $video_url); // Для работы с сокращённой ссылкой
$video_url = explode('&', $video_url)[0]; // Отсекаем get переменные, например начало воспроизведения, они не встраиваемые

$ratio_type_arr = array(1, 2);

if (!in_array($ratio, $ratio_type_arr)) {
	$SITE->errLog('Некорректный тип фона: '.$ratio.' block_id => '.$block_id);
	exit;
}

$arr = array(
	'text' => $text,
	'url' => $video_url,
	'ratio' => $ratio,
	'button_1' => 
		array(
			'on' => 1,
			'text' => 'Подробнее',
			'link' => '',
			'bg_color' => '#0079ca',
			'text_color' => '#ffffff',
			'style' => 'solid',
			'radius' => '40',
		),
	'button_2' => 
		array(
			'on' => 1,
			'text' => 'Подробнее',
			'link' => '',
			'bg_color' => '#ff8040',
			'text_color' => '#ff8040',
			'style' => 'border',
			'radius' => '40',
		)
);

$content['videos'][] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>