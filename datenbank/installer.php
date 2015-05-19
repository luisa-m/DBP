<!DOCTYPE html>
<html>
	<head>
	<title>DB-Installation</title>
	</head>
	<body><h1 style="text-align: center;">Datenbank-Installation</h1>

<?php
if (isset($_REQUEST["inhalt"])){
	$datei = fopen("../hilf/db_helper.php", "w");
	$vorlage = file_get_contents("db_helper_vorlage.php");
	$inhalt = str_replace(array("__HOST__", "__USER__", "__PASSWORT__"), array($_REQUEST["host"], $_REQUEST["user"], $_REQUEST["passwort"]), $vorlage);
	fwrite($datei, $inhalt);
	fclose($datei);
	$erfolg = fuehreSQLDateiAus('struktur.sql', false);
	if ($_REQUEST["inhalt"] == 1){
		$erfolg = $erfolg && fuehreSQLDateiAus('inhalt.sql', true);
	}
	if ($erfolg){
		echo '<p>Die Installation wurde erfolgreich durchgeführt</p>';
	} else {
		echo '<p>Leider ist bei der Installation etwas schiefgegangen. Möglicherweise funktioniert die Anwendung nicht ordnungsgemäß.</p>';
	}
} else {?>
	<p>Die Installation der Datenbank erfordert, dass Sie Zugriff auf eine laufende MySQL-Instanz haben. Sie können deren Host sowie Benutzernamen und Passwort unten angeben.</p>
	<form method="post" action="">
		<table border="0">
			<tr>
				<td>Host</td>
				<td><input type="text" name="host" value="localhost" /></td>
			</tr>
			<tr>
				<td>Username</td>
				<td><input type="text" name="user" value="root" /></td>
			</tr>
			<tr>
				<td>Passwort</td>
				<td><input type="password" name="passwort" /></td>
			</tr>
		</table>
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
		$end = ($i == sizeof($matches[0]) ? false : $matches[0][$i][1]-($i == 0 ? 1 : (strlen($matches[1][$i-1][0])+1)));
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
