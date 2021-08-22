<?php
defined('AUTH') or die('Restricted access');

class BlockMenuBasket
{
	public function getCatalogs()
	{
		global $db;
		
		$stmt = $db->query("SELECT id, name FROM components WHERE component = 'catalog' AND type = 'shop'");
		if ($stmt->rowCount() > 0) {
			return $stmt->fetchAll();	
		}
	}
}