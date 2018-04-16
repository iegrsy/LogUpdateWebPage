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
# test get url
# ?time=23:19:08&date=22.01.2018&V1=233,7&I1=0,00&P1=0&V2=233,2&I2=0&P2=0&V3=227,8&I3=0,00&P3=0
#if ($_GET["time"] || $_GET["date"] || $_GET["V1"] || $_GET["I1"] || $_GET["P1"] || $_GET["V2"] || $_GET["I2"] || $_GET["P2"] || $_GET["V3"] || $_GET["I3"] || $_GET["P3"]) {
#	# code...
#	$arr = array(
#		'time' => $_GET["time"],
#		'date' => $_GET["date"],
#		'V1' => $_GET["V1"],
#		'I1' => $_GET["I1"],
#		'P1' => $_GET["P1"],
#		'V2' => $_GET["V2"],
#		'I2' => $_GET["I2"],
#		'P2' => $_GET["P2"],
#		'V3' => $_GET["V3"],
#		'I3' => $_GET["I3"],
#		'P3' => $_GET["P3"]
#		);

if ($_GET["ea"] || $_GET["ee"] || $_GET["ke"] || $_GET["iea"] || $_GET["iee"] || $_GET["iek"]){
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
	$json = file_get_contents('./test.json');
	$obj = json_decode($json, true);
	print_r($obj);
	?>

</body>
</html>