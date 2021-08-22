<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];

$video_url = trim(strip_tags($_POST['video_url']));
$video_num = intval($_POST['video_num']);
$ratio = intval($_POST['ratio']);

$video_url = str_replace('watch?v=', 'embed/', $video_url); // Для работы с ссылкой из адреса
$video_url = str_replace('youtu.be', 'youtube.com/embed', $video_url); // Для работы с сокращённой ссылкой

$video_url = explode('&', $video_url)[0]; // Отсекаем get переменные, например начало воспроизведения, они не встраиваемые

$ratio_type_arr = array(1, 2);

if (!in_array($ratio, $ratio_type_arr)) {
	$SITE->errLog('Некорректный тип фона: '.$ratio.' block_id => '.$id);
	exit;
}

$i = $video_num - 1;
$content['videos'][$i]['url'] = $video_url;
$content['videos'][$i]['ratio'] = $ratio;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>