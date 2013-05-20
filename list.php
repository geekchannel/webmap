<?
require('settings.php');
$files = array();
$list_files = scandir(RESULTS_PATH);
foreach ($list_files as $filename) {
	$files[filectime(RESULTS_PATH . $filename)] =array(
		'filename' => $filename,
		'ctime' => filectime(RESULTS_PATH . $filename)
	); 
}
krsort($files);
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container">
<a href="<?=APP_URL?>"><button class="btn btn-inverse">to index</button></a>
<hr>
<h1 >Scan results:</h1>
<table class="table">
<tr>
	<td><b>File</b></td>
	<td><b>Creation date</b></td>
</tr>
<?
foreach ($files as $file):
	if ($file['filename'] != "." && $file['filename'] != ".."):
?>
<tr>
	<td><a href="<?=APP_URL . "result.php?f=" . $file['filename']?>"><?=$file['filename']?></a></td>
	<td><?=date("r", $file['ctime'])?></td>
</tr>
<?
	endif;	
endforeach;
?>
</table>
</div>
</body>
</html>
<?
?>
