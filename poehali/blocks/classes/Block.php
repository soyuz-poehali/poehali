<?php
defined('AUTH') or die('Restricted access');
// Поле 'status': 0 - скрыть, 1 - показать, 2 - только десктоп, 3 - только на мобильных устройствах 

class Block
{
	public function getBlock($id)
	{
		global $db;
		$stmt = $db->prepare("SELECT * FROM blocks WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$b = $stmt->fetch();
		$b['content'] = unserialize($b['content']);
		return $b;
	}
}