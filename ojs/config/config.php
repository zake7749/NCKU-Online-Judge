<?php
	$host="140.116.245.148";//please modify as "140.116.245.148" when you upload
	$user="f74026284";//your student id.
	$pw="isrlabncku";//your pw.
	$db="f74026284";//your student id.
	$link = mysql_connect($host,$user,$pw);
	if(!$link) {die('Could not connect: ' . mysql_error());}
	if(!mysql_select_db($db,$link)) {die("Connect database fail!");}

?>
