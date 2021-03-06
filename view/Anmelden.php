﻿<?php 
require_once('../fach/Kontext.php');
$kontext = new Kontext();

// Wenn Formular abgesendet, versuchen einzuloggen
if(isset($_REQUEST["einloggen"]))
{
	try 
	{
		$kontext->einloggen($_REQUEST["nickname"], $_REQUEST["password"]);
		header("location:hauptseite.php");
	}
	catch(Exception $e)
	{
		if($e->getMessage() == "UngueltigesPasswort")
		{
			$Fehlermeldung = "Falscher Benutzername oder falsches Passwort.";
		}
		else
		{
			$Fehlermeldung = "Es ist ein unerwarteter Fehler aufgetreten (" . $e->getMessage() . ")";
		}
	}
	
// Auf Anforderung ausloggen
} elseif (isset($_REQUEST["abmelden"]) && $_REQUEST["abmelden"] == 1){
	$kontext->ausloggen();
	
// Wenn bereits eingeloggt, auf Hauptseite weiterleiten
} elseif ($kontext->isAngemeldet()){
	header("location:hauptseite.php");
}

// Wenn kein Einlog-Versuch gestartet oder Einloggen fehlgeschlagen: Formular anzeigen
if(!isset($_REQUEST["einloggen"]) || isset($Fehlermeldung))
{
	?>
	 <!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Kikeriki! Bitte logge dich ein</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="shortcut icon" type="image/x-icon" href="Icon.png">
</head>
<body class="logo">
<div align=center>
	<h1 class="white">Willkommen bei Kikeriki! <Br> Die neusten Updates für dich auf einen Blick!</h1>
	<form action="" method="POST">
	<table class="t1">
		<tr>
				<td>Nickname</td>
				<td><input required type="text" name="nickname" placeholder="Nickname" value="<?php if(!empty($_REQUEST["nickname"])){echo $_REQUEST["nickname"];}?>"/></td>
		</tr>
		<tr>
				<td>Passwort</td>
				<td><input required type="password" name="password" placeholder="Passwort"/></td>
		</tr>
	</table>
	<br>


		<input type="submit" name="einloggen" value="Einloggen">
	</form>
	<br>
	<p><font color="white">Noch nicht Mitglied der Community? <br><a href="Registrieren.php" style="color: white">Jetzt registrieren</a></font></p>
	<?php 
	if(isset($Fehlermeldung))
	{
		echo '<div class="fehlermeldung">' . $Fehlermeldung . '</div>';
	}
	?>
</div>
</body>

</html>
<?php }?>


