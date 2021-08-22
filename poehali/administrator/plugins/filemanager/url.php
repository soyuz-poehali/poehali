<?php
defined("AUTH") or die("Restricted access");

$dir = isset($_GET['d']) ? $_GET['d'] : '';

$dir = decode($dir, $v);

$FuncNum = isset($_GET["CKEditorFuncNum"]) ? $_GET["CKEditorFuncNum"] : 0;

// Своё декодирование + точка для файлов
$dir = preg_replace('/[^a-z0-9_\-\/\.]/i','',$dir); // Внимание! Не склеиваем три выражения в одно, иначе вместо ../../ == '' будет ../../ == //
$dir = preg_replace('/^(\/*)|(\/*)$/i','',$dir); // удаляем первый (первые) и последний (последние) слеши
$dir = preg_replace('/(\/){2,}/','/',$dir); // удаляем двойные слеши


$url = '/files/'.$dir;

echo '
	<script type="text/javascript">
		if (window.opener.CKEDITOR) {
			window.opener.CKEDITOR.tools.callFunction("'.$FuncNum.'", "'.$url.'", "");
			window.close();
		} else {
			window.opener.open(\''.$url.'\');
			window.close();
		}
	</script>
';
// echo $url;

exit;
?> 