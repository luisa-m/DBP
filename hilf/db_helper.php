<?php
function db_connect(){
	return new PDO('mysql:host=localhost;dbname=hausarbeit_twitter', 'root', '');
}
function db_connect_wo_database(){
	return new PDO('mysql:host=localhost', 'root', '');
}
?>