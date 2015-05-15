<!DOCTYPE html>
<html>
	<head>
	<title>DB-Installation</title>
	</head>
	<body><h1 style="text-align: center;">Datenbank-Installation</h1>

<?php
if (isset($_REQUEST["inhalt"])){
	$erfolg = fuehreSQLDateiAus('struktur.sql', false);
	if ($_REQUEST["inhalt"] == 1){
		$erfolg = fuehreSQLDateiAus('inhalt.sql', true);
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
function fuehreSQLDateiAus($path, $selectDatabase){
	$result = true;
	require_once '../hilf/db_helper.php';
	if ($selectDatabase) $dbh = db_connect();
	else $dbh = db_connect_wo_database();	
	$file = file_get_contents($path);
	$delim = ';';
	preg_match_all('/DELIMITER (.*)(\s|$)/', $file, $matches, PREG_OFFSET_CAPTURE);
	for ($i=0;$i<=sizeof($matches[0]);$i++){
		$begin = ($i == 0 ? 0 : $matches[1][$i-1][1]+strlen($matches[1][$i-1][0]));
		$end = ($i == sizeof($matches[0]) ? false : $matches[0][$i][1]-strlen($matches[1][$i-1][0])-1);
		if (!$end) $query = substr($file, $begin);
		else $query = substr($file, $begin, $end-$begin);
		if (!$dbh->exec($query)){
			$errInfo = $dbh->errorInfo();
			if ($errInfo[0] != "00000"){
				$result = false;
				echo '<p>Die Abfrage</p><p>'.$query.'</p><p>führte zu einem Fehler: '.$errInfo[2].'(SQLSTATE Error Code: '.$errInfo[0].', Driver Error Code: '.$errInfo[1].')</p>';
			}
		}
	}
	return $result;
}
?>
</body>
</html>
