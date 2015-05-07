<?php
class Benutzer{
	
	private $id;
	
	
	public function __construct($id){
		$this->$id = $id;
		
		require_once(dirname($_SERVER['SCRIPT_FILENAME'])."/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Nickname, Vorname, Nachname, Passwort FROM Benutzer WHERE ID = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->nickname = $res["Nickname"];
		$this->vorname = $res["Vorname"];
		$this->nachname = $res["Nachname"];
		$this->passwort = $res["Passwort"];
	}
	
	/**
	 * Gibt den Nicknamen des Benutzers zurück.
	 * @return String Nickname
	 */
	public function getNickname(){
		return $this->nickname;
	}
	
	/**
	 * Gibt den Vornamen des Benutzers zurück.
	 * @return String Vorname
	 */
	public function getVorname(){
		return $this->vorname;
	}
	
	/**
	 * Gibt den Nachnamen des Benutzers zurück.
	 * @return String Nachname
	 */
	public function getNachname(){
		return $this->nachname;
	}
	
	
	/**
	 * Prüft, ob das eingegebene Passwort korrekt ist.
	 * @param unknown $pw Passwort des Benutzers 
	 * @return boolean True = Passwort ist korrekt; False = Passwort ist nicht korrekt
	 */
	public function pruefePasswort($pw){
		
		if($pw == $this->passwort){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Gibt die ID's der Benutzer, denen ein Benutzer folgt, zurück.
	 * @return multitype:Benutzer
	 */
	public function getGefolgte(){
		$stmt = $dbh->prepare("SELECT Gefolgter FROM Folgen WHERE Folgender = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
		$res = $stmt->fetchAll();
		$gefolgteBenutzer = array();
		foreach ($res as $gefolgter){
			$gefolgteBenutzer[]= new Benutzer($gefolgter["Gefolgter"]);
		}
		
		return $gefolgteBenutzer;
	}
	
	
	
	public function getGefolgteNachrichten(){
		$stmt = $dbh->prepare("SELECT Inhalt FROM Nachricht WHERE Folgender = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
		$res = $stmt->fetchAll();
		$gefolgteNachrichten = array();
		foreach ($res as $gefolgter){
			$gefolgteNachrichten[]= new Nachricht($inhalt["Inhalt"]);
		}
		
		return $gefolgteNachrichten;
	}
	
	public function schreibeNachricht($inhalt){
		$stmt = $dbh->prepare("UPDATE Nachricht SET ID = :ID, Benutzer WHERE Folgender = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
	}
	
	public static function getBenutzerliste(){
	}
	
	public static function getBenutzer($nickname){
	}
	
	public static function registrieren($nickname,$vorname,$nachname,$passwort){
	}
	
	public function folgen($nickname){
	}
	
}
?>