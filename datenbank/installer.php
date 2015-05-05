<?php

require_once '../hilf/db_helper.php';
$dbh = db_connect_wo_database();
$file_content = explode(";", file_get_contents('_DATABASE_TWITTER_.sql'));
foreach ($file_content as $line){
	$dbh->exec($line);
}
?>
