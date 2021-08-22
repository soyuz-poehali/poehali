<?php
defined('AUTH') or die('Restricted access');

class PersonalInformation
{
	public function getText() 
	{
		global $db;

		$stmt = $db->query("SELECT settings FROM settings WHERE id = 2");
		return $stmt->fetchColumn();
	}

	public function updateText($text) 
	{
		global $db;

		$stmt = $db->prepare("UPDATE settings SET settings = :settings WHERE id = 2");
		$stmt->execute(array('settings' => $text));
	}
}

?>