<?php
defined('AUTH') or die('Restricted access');

$code = '';

echo json_encode(array('answer' => 'success', 'content' => $code));

?>