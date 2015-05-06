<?php

fuehreSQLDateiAus('_DATABASE_TWITTER_.sql');

// Ermöglicht die Ausführung von SQL-Dateien mit Delimiter-Wechsel
function fuehreSQLDateiAus($path){
	require_once '../hilf/db_helper.php';
	$dbh = db_connect_wo_database();	
	$file = file_get_contents($path);
	$delim = ';';
	preg_match_all('/DELIMITER (.*)(\s|$)/', $file, $matches, PREG_OFFSET_CAPTURE);
	$delimChanges = count($matches[0]);
	$i = 0;
	$offset = 0;
	while (!preg_match('/^\s*$/', $file)){
		$posDelim = strpos($file, $delim);
		if ($posDelim === false){
			$posDelim = strlen($file)+1;
		}
		if ($i < $delimChanges && $matches[0][$i][1] < $posDelim+$offset){
			$delim = $matches[1][$i][0];
			$file = substr($file, $matches[2][$i][1]-$offset);
			$offset = $matches[2][$i][1];
			$i++;
		} else {
			$query = substr($file, 0, $posDelim);
			$file = substr($file, $posDelim+strlen($delim));
			$offset += $posDelim+strlen($delim);
			if ($dbh->exec($query) === false){
				echo $query;
				print_r($dbh->errorInfo());
			}
		}
	}
}
?>
