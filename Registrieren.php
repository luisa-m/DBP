<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Bitte registrieren Sie sich</title>
	<link rel="stylesheet" type="text/css" href="Background.css">
	<style>
		h1{color:white; font-size: 16pt}
		input[type=submit] {
    		width: 70pt; margin: 2pt; background-color: white}
    	.t1{color: white}
	</style>
</head>
<body>
<div align=center>
	<h1>Willkommen bei Twitter 2.0 <Br> Registriere dich jetzt und bleibe in Verbindung</h1>
	<form  action="" method="post">
	<table class="t1">
		<tr style="width: 358px; ">
				<td>Name</td>
				<td><input required type="text" name="name" placeholder="Name" value="<?php if(!empty($_POST["name"])){echo $_POST["name"];}?>"/></td>
		</tr>
		<tr>
				<td>Passwort</td>
				<td><input required type="password" name="password1" placeholder="Passwort"/></td>
		</tr>
		<tr>
				<td>Passwort bestätigen</td>
				<td><input required type="password" name="password2" placeholder="Passwort wiederholen"/></td>
		</tr>
	</table>
	<br>
		<input type="submit" name="registrieren" value="Registrieren">
	</form>
	<form action="Anmelden.html">
		<input type="submit" name="abbrechen" value="Abbrechen">
	</form>
	<?php
		if(isset($_REQUEST["registrieren"]))
		{
		if(strcmp($_POST["password1"],$_POST["password2"]) == 0)
		{
			try
				{
					$name = $_POST["name"];
					$password1 = $_POST["password1"];
					$dbh = new PDO('mysql:host=localhost;dbname=hausarbeitTEST', 'root', '');	
					$res = $dbh->query("INSERT INTO nutzer(name,passwort) VALUES ('$name','$password1');");
					$dbh=null;
				}
				catch(PDOException $e)
				{
					echo "Datenbank-Fehler: " . $e->getMessage();
				}
		}
		else
		{
			echo "<div style=\"color: white;\">Die Passwörter stimmen nicht überein. Bitte überprüfen Sie ihre Eingaben.</div>";
		}		
		}
	?>	
</div>		
</body>
</html>