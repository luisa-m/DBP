<?php
function db_connect(){
	$dbh = new PDO('mysql:host=localhost;dbname=hausarbeit_twitter', 'root', '');
	$dbh->exec("SET NAMES utf8");
	return $dbh;
}
function db_connect_wo_database(){
	return new PDO('mysql:host=localhost', 'root', '');
}
?>