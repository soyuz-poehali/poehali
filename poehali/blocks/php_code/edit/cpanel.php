<?php
defined('AUTH') or die('Restricted access');

$content = '';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>