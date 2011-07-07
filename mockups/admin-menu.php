<?php

$dbhost = "localhost";
$dbuser = "nova";
$dbpass = "";
$dbname = "nova3_upgrade_nova1";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$section = (isset($_POST['section'])) ? $_POST['section'] : false;

$sql = "SELECT * FROM nova_menu_items WHERE menu_type = 'adminsub' AND menu_cat = '$section'";
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result))
{
	$data[] = '<li><a href="#">'.$row['menu_name'].'</a></li>';
}

echo '<ul>'.implode('', $data).'</ul>';

mysql_close($conn);
