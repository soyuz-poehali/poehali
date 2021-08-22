<?php
defined('AUTH') or die('Restricted access');

$hash = $_POST['hash'];
$id = $_POST['id'];

$CATALOG->orderDeleteItem(array('catalog_id' => $data['content']['catalog_id'], 'id' => $id));

echo json_encode(array('answer' => 'success'));
exit();