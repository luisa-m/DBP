<?php
function db_connect(){
	$dbh = new PDO('mysql:host=__HOST__;dbname=hausarbeit_twitter', '__USER__', '__PASSWORT__');
	$dbh->exec("SET NAMES utf8");
	return $dbh;
}
function db_connect_wo_database(){
	return new PDO('mysql:host=__HOST__', '__USER__', '__PASSWORT__');
}
?>