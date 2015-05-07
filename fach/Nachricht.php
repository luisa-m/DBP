<?php

class Nachricht implements JsonSerializable {
	
	private $benutzer;
	private $inhalt;
	private $datum;
	
	public function __construct($id, $benutzer = null){
		require_once("/../hilf/db_helper.php");
		require_once("Benutzer.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Benutzer, Inhalt, Datum FROM Nachricht WHERE ID = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->inhalt = $res["Inhalt"];
		if ($benutzer == null){
			$this->benutzer = Benutzer::getBenutzer($res["Benutzer"]);
		} else {
			$this->benutzer = $benutzer;
		}		
		$this->datum = new DateTime($res["Datum"]);
	} 
	
	public function getInhalt(){
		return $this->inhalt;
	}
	
	public function getBenutzer(){
		return $this->benutzer;
	}
	
	public function getDatum(){
		return $this->datum;
	}
	
	public static function sucheNachHashtag($hashtag){
		require_once(dirname($_SERVER['SCRIPT_FILENAME']).'/hilf/db_helper.php');
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT nh.Nachricht FROM nachricht_hashtag nh, Hashtag h WHERE nh.Hashtag = h.ID AND h.Tag = :Tag");
		$stmt->bindParam(':Tag', $hashtag);
		if (!$stmt->execute()){
			print_r($stmt->errorInfo());
		}
		$result = Array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$result[] = new Nachricht($row["Nachricht"]);
		}
		return $result;
	}
	
	public function jsonSerialize() {
		return [
				'benutzer' => $this->getBenutzer(),
				'inhalt' => $this->getInhalt(),
				'datum' => $this->getDatum()
		];
	}
	
}

?>