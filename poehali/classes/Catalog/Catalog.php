<?php
defined('AUTH') or die('Restricted access');

class Catalog
{
	public function getCatalogs()
	{
		global $db;
		$query = $db->query("SELECT id, component, name, url, type, settings, status FROM components WHERE component = 'catalog' ORDER BY ordering");

		if ($query->rowCount() > 0)
			return $query->fetchAll();
		return false;
	}
}