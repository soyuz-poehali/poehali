<?php
defined('AUTH') or die('Restricted access');


$content =
'<div>'.
	'<h2>Помощь - "Php код"</h2>'.
	'<div><b>Принцип работы:</b></div>'.
	'<div>При добавлении блока, создаётся указанный php файл в папке /blocks/php_code/frontend/files</div>'.
	'<div>&nbsp;</div>'.
	'<div>В данном файле должна быть функция с именем = имени файла(без расширения), которая возвращает контент, размещаемый в блоке.</div>'.
	'<div>&nbsp;</div>'.
	'<div><b>ВНИМАНИЕ!</b></div>'.
	'<div>В режиме редактирования, что бы не было схлопывания блока, код выводится в блоке с минимальной высотой 50px, эта обёртка будет отсутствовать при выводе в frontend.</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));
exit;

?>