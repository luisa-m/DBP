<?php 
require_once('../fach/Benutzer.php');
require_once('../fach/Kontext.php');

// Wenn Formular abgesendet, versuchen, zu registrieren
if(isset($_REQUEST["registrieren"]))
{
	if(strcmp($_POST["password1"],$_POST["password2"]) == 0)
	{
		try
		{
			Benutzer::registrieren($_REQUEST["nickname"],$_REQUEST["vorname"],$_REQUEST["nachname"],$_REQUEST["password1"]);
			$kontext = new Kontext();
			$kontext->einloggen($_REQUEST["nickname"], $_REQUEST["password1"]);
			header("location:Hauptseite.php");
		}
		catch(Exception $e)
		{
			$Fehlermeldung = "Es ist ein unerwarteter Fehler aufgetreten (" . $e.getMessage() . ")";
		}
	}
	else {
		$Fehlermeldung = "Die Passwörter stimmen nicht überein. Bitte überprüfen Sie Ihre Eingaben.";
	}
}


// Wenn kein Registrierversuch gestartet oder Registrierung fehlgeschlagen: Formular anzeigen
if(!isset($_REQUEST["registrieren"]) || isset($Fehlermeldung))
{
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Kikeriki! Bitte registrieren Sie sich</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="shortcut icon" type="image/x-icon" href="Icon.png">
</head>
<body class="logo">
<div align=center>
	<h1 class="white">Willkommen bei Kikeriki! <Br> Registriere dich jetzt und bleibe in Verbindung</h1>
	<form  action="" method="post">
	<table class="t1">
		<tr>
				<td>Nickname</td>
				<td><input required type="text" name="nickname" placeholder="Nickname" value="<?php if(!empty($_POST["nickname"])){echo $_POST["nickname"];}?>"/></td>
		</tr> <tr>
				<td>Vorname</td>
				<td><input required type="text" name="vorname" placeholder="Vorname" value="<?php if(!empty($_POST["vorname"])){echo $_POST["vorname"];}?>"/></td>
		</tr><tr>
				<td>Nachname</td>
				<td><input required type="text" name="nachname" placeholder="Nachname" value="<?php if(!empty($_POST["nachname"])){echo $_POST["nachname"];}?>"/></td>
		</tr><tr>
				<td>Passwort</td>
				<td><input required type="password" name="password1" placeholder="Passwort"/></td>
		</tr><tr>
				<td>Passwort bestätigen</td>
				<td><input required type="password" name="password2" placeholder="Passwort wiederholen"/></td>
		</tr>
	</table>
	<br>
		<input type="submit" name="registrieren" value="Registrieren">
	</form>
	<form action="Anmelden.php">
		<input type="submit" name="abbrechen" value="Abbrechen">
	</form>	
	<?php 
	if(isset($Fehlermeldung))
	{
		echo '<div class="fehlermeldung">' . $Fehlermeldung . '</div>';
	}
	?>
</div>
</body>
</html>
<?php } ?>