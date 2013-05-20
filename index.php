<?
require('settings.php');


set_time_limit(0);
if (isset($_POST['host'])):
	if (!defined('WEB_SCANS')) {
        	die('Web scans disabled');
	}

	$host = trim($_POST['host']);

	if (!preg_match('/^([0-9a-z])([a-z0-9.\-]+)([0-9a-z])$/', $host)) {
		die('Wrong host or IP address');
	}

	$filename = substr(md5(time() . rand(1, 10)), 0, 5);
	$command = "nmap ". NMAP_ARGS . " -oX " . RESULTS_PATH . $filename . " " . escapeshellarg($host);
	$result_scan = shell_exec($command);
	if (is_null($result_scan)) {
		die('Something went wrong');
	} else {
		header('Location: result.php?f=' . $filename);
	}
else:
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>WebMap - Do scans online!</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="js/jquery.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
	<h1>WebMap</h1>
<? if (!defined('WEB_SCANS')): ?>
	<p>Web scans disabled</p>
<? else: ?>
	<p>Enter host or IP address to scan: </p>
	<form id="scanform" class="form-inline" action="?" method="POST">
		<input type="text" name="host" class="input-large" placeholder="hostname/IP"> <button type="submit" class="btn">Scan</button> 
	</form>
	<div id="waiter"></div>
<? endif; ?>
	<hr>
	<a href="<?=APP_URL . "list.php"?>"><button class="btn btn-inverse">View existing results</button></a>
</div>
<script>
 $('#scanform').submit(function(){ $('#waiter').append("<b>please, wait</b>"); });
</script>
</body>
</html>
<? endif; ?>

