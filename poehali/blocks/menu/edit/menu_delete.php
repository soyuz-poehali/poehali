<?php
defined('AUTH') or die('Restricted access');

$block_id = intval($_POST['id']);
$menu_id = intval($_POST['menu_id']);

// НАХОДИМ БЛОК
$stmt = $db->prepare("SELECT settings FROM blocks WHERE id = :id AND site_id = :site_id AND page_id = 0 AND type = 'menu'");
$stmt->execute(array('id' => $block_id, 'site_id' => $site_id));
if($stmt->rowCount() == 0)
{
	echo json_encode(array('answer' => 'error', 'content' => 'Page not found'));
	$SITE->errLog('Не найден block_id => '.$block_id.' для сайта site_id => '.$site_id.', cтраница => 0 (menu), пользователь => '.$USER->auth());
	exit;
}
$s = $stmt->fetchColumn();
$BLOCK = unserialize($s);

// Проверяем количество пунктов меню
$stmt_select = $db->prepare("SELECT id FROM menu WHERE site_id = :site_id");
$stmt_select->execute(array('site_id' => $site_id));
if($stmt_select->rowCount() == 1)
{
	echo json_encode(array('answer' => 'error', 'message' => 'Это последний пункт, его нельзя удалить!'));
	exit;
}

$stmt = $db->prepare("DELETE FROM menu WHERE id = :menu_id AND site_id = :site_id");
$stmt->execute(array('menu_id' => $menu_id, 'site_id' => $site_id));

echo json_encode(array('answer' => 'success'));
exit;

?>