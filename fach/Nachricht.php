<?php

class Nachricht {
	
	private $benutzer;
	private $inhalt;
	private $datum;
	
	public function __construct($id){
		require_once("../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Benutzer, Inhalt, Datum FROM Nachricht WHERE ID = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->inhalt = $res["Inhalt"];
		$this->benutzer = $res["Benutzer"];
		$this->datum = new DateTime($res["Datum"]);
	} 
	
	public function getInhalt(){
		return $this->inhalt;
	}
	
	public function getBenutzer(){
		return Benutzer::getBenutzer($this->benutzer);
	}
	
	public function getDatum(){
		return $this->datum;
	}
	
	public static function sucheNachHashtag($hashtag){
		require_once('../hilf/db_helper.php');
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT nh.Nachricht FROM NachrichtHashtag nh, Hashtag h WHERE nh.Hashtag = h.ID AND h.Tag = :Tag");
		$stmt->bindParam(':Tag', $hashtag);
		$stmt->execute();
		$result = Array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$result[] = new Nachricht($row["Nachricht"]);
		}
		return $result;
	}
	
}

?>