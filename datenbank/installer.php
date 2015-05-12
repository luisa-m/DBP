<!DOCTYPE html>
<html>
	<head>
	<title>DB-Installation</title>
	</head>
	<body><h1 style="text-align: center;">Datenbank-Installation</h1>

<?php
if (isset($_REQUEST["inhalt"])){
	$erfolg = fuehreSQLDateiAus('struktur.sql');
	if ($erfolg && $_REQUEST["inhalt"] == 1){
		$erfolg = fuehreSQLDateiAus('inhalt.sql');
	}
	if ($erfolg){
		echo '<p>Die Installation wurde erfolgreich durchgeführt</p>';
	} else {
		echo '<p>Leider ist bei der Installation etwas schiefgegangen. Möglicherweise funktioniert die Anwendung nicht ordnungsgemäß.</p>';
	}
} else {?>
	<p>Die Installation der Datenbank erfordert, dass auf Ihrem localhost ein MySQL-Instanz installiert ist und läuft. Sie muss über einen Benutzer mit dem Benutzernamen root und einem Leerstring als Passwort verfügen.</p>
	<form method="post" action="">
		<button type="submit" name="inhalt" value="0">Datenbank ohne Inhalt aufbauen</button>
		<button type="submit" name="inhalt" value="1">Datenbank mit Inhalt aufbauen</button>
	</form>
<?php 
}

// Ermöglicht die Ausführung von SQL-Dateien mit Delimiter-Wechsel
function fuehreSQLDateiAus($path){
	$result = true;
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
			if (!$dbh->exec($query)){
				echo '<p>'.$dbh->errorInfo()[2].'</p>';
				$result = false;
			}
		}
	}
	return $result;
}
?>
</body>
</html>
