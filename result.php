<?
require('settings.php');
# WEBMAP - do your nmap scans like a boss!
#
# Nmap XML to HTML.
# Usage - /result.php?f=test
# where test is name of file

$folder = RESULTS_PATH;

if (empty($_GET['f'])) {
	die('No filename, bro');
}

if (!preg_match('/^([a-z0-9.\-]+)$/', $_GET['f'])) {
	die('Wrong file name');
}

// xml file to parse
$file =  $folder .  $_GET['f'];
$result =  simplexml_load_file($file);

if (!$result) {
	die('Wrong file name');
}

if ($result->host->status['state'] != 'up') {
	die('Host is down');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>WebMap scan results: <?=$result->host->address['addr']?></title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container">
<a href="<?=APP_URL?>"><button class="btn btn-inverse">to index</button></a>
<a href="<?=APP_URL?>list.php"><button class="btn btn-inverse">to list</button></a>

	<h1 >Scan results for: <?=$result->host->address['addr']?></h1>
	<hr>
<?/* General INFO about host */?>
	<div class="well">
		<p><b>IP</b>: <?=$result->host->address['addr']?></p>

	<? if ($result->host->hostnames->hostname): ?>
		<? foreach ($result->host->hostnames->hostname as $hostname):?>
			<p><b>Hostname</b>: <?=$hostname['name']?> <em>(<?=$hostname['type']?>)</em></p>
		<? endforeach; ?>
	<? endif; ?>

	<? if ($result->host->os): ?>
		<p>
			<b>Operating System</b>:
			<? if($result->host->os->osmatch): ?>
				<? foreach($result->host->os->osmatch as $os): ?>
					<?=$os['name']?> (<?=$os['accuracy']?>%). 
				<? endforeach; ?>
			<? endif;?>
		</p>			
	<? endif; ?>
	<? if ($result->host->distance): ?>
		<p><b>Distance</b>: <?=$result->host->distance['value']?> hops</p>
	<? endif; ?>
	<? if ($result->host->uptime): ?>
		<p><b>Last boot</b>: <?=$result->host->uptime['lastboot']?></p>
	<? endif; ?>

	</div>

<?/* If open ports: */?>
	<? if ($result->host->ports->port): ?>
		<h1>Ports:</h1>
		<hr>
		<? foreach ($result->host->ports->port as $port): ?>

			<div>
				<? if ($port->state['state'] == "open"):?>
					<span class="badge badge-success"><?=$port->state['state']?></span>
				<? else: ?>
					<span class="badge"><?=$port->state['state']?></span>
				<? endif; ?>

				<b><?=$port['portid']?></b> (<?=$port['protocol']?>) 
					Service name: <b><?=$port->service['name']?></b>.
				<? if ($port->service['product']): ?>
					Product: <b><?=$port->service['product']?></b>. 
				<? endif; ?>
				<? if ($port->service['version']): ?>
					Version: <b><?=$port->service['version']?></b>. 
				<? endif; ?>

				<? if ($port->script): ?>
					<? foreach ($port->script as $script): ?>
						<div class="well">	
							<small>
								<b><?=$script['id']?></b>:
								<pre><?=$script['output']?></pre>
							</small>
						</div>
					<? endforeach; ?>
				<? endif;?>
			</div>

		<? endforeach; ?>
	<? endif; ?>

<?/* If extra ports: */?>
	<? if ($result->host->ports->extraports): ?>
		<? foreach ($result->host->ports->extraports as $extraport): ?>
			<? if ($extraport['state'] == 'closed'): ?>
				<p class="text-error">Closed ports: <?=$extraport['count']?></p>
			<? endif; ?>
		<? endforeach; ?>
	<? endif;?>
	<hr>
<?/* Other info */?>
		<p><?=$result->runstats->finished['summary']?></p>	
</div>
</body>
</html>
