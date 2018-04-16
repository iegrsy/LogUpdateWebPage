<?php 
date_default_timezone_set('Europe/Istanbul');
/* server timezone */
define('CONST_SERVER_TIMEZONE', 'UTC');

/* server dateformat */
define('CONST_SERVER_DATEFORMAT', 'YmdHis');

function now($str_user_timezone,
	$str_server_timezone = CONST_SERVER_TIMEZONE,
	$str_server_dateformat = CONST_SERVER_DATEFORMAT) {

  // set timezone to user timezone
	date_default_timezone_set($str_user_timezone);

	$date = new DateTime('now');
	$date->setTimezone(new DateTimeZone($str_server_timezone));
	$str_server_now = $date->format($str_server_dateformat);

  // return timezone to server default
	date_default_timezone_set($str_server_timezone);

	return $str_server_now;
}

if ($_GET["ea"] || $_GET["ee"] || $_GET["ek"] || $_GET["iea"] || $_GET["iee"] || $_GET["iek"]){
	$arr = array(
		'ea' => $_GET["ea"],
		'ee' => $_GET["ee"],
		'ek' => $_GET["ek"],
		'iea' => $_GET["iea"],
		'iee' => $_GET["iee"],
		'iek' => $_GET["iek"]
	);

	$dt = new DateTime();
	$updatetime = $dt->format('Y-m-d H:i:s');

	$jarr = array('result' => $arr, 'last_update' => $updatetime);
	$jstr = json_encode($jarr);

	$f = 'test.json';
	$fp = fopen($f, 'w');
	fwrite($fp, $jstr);
	fclose($fp);
	exit();
}

$page = $_SERVER['PHP_SELF'];
$sec = "3";

?>

<!DOCTYPE html>
<html>
<head>
	<title>My test page</title>
	<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
</head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<body>
	<?php
	echo "Watch the page reload itself in 3 second! </br></br></br></br>";
	?>

	<table style="width:60%" border="1">
		<tr>
			<th>Comment</th>
			<th>index</th> 
		</tr>

		<?php 
		$json = file_get_contents('./test.json');
		$obj = json_decode($json, true);
		print_r($obj);

		foreach($obj as $row) {
			foreach($row as $key => $val) {
				// echo $key . ': ' . $val;
				// echo '<br>';
				echo "<tr><td>" . $key . "</td><td>" . $val . "</td></tr>";
			}
		}
		?>
	</table>
</body>
</html>