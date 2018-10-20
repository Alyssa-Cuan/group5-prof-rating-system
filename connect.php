<?php
//connect script

DEFINE ('DB_USER', 'bb4df0955f60cd');
DEFINE ('DB_PASSWORD', '3b26c66b');
DEFINE ('DB_HOST', 'us-cdbr-iron-east-01.cleardb.net');
DEFINE ('DB_NAME', 'heroku_a970e1b97180e5d');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL: ' .
mysqli_connect_error());

echo "DIE";
?>
