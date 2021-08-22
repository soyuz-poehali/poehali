<?php
defined('AUTH') or die('Restricted access');

function block_code($data)
{
	global $SITE;

	return '<div id="block_'.$data['id'].'" class="block">'.$data['content'].'</div>';
}
?>