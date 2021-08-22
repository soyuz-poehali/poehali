<?php
defined('AUTH') or die('Restricted access');

$content = 
'<h1>Помощь</h1>'.
'<div>111111111111111111</div>';	


echo json_encode(array('answer' => 'success', 'content' => $content));
exit;
?>