<?php
function db_connect(){
	return new PDO('mysql:host=localhost;dbname=hausarbeit_twitter', 'root', '');
}
?>