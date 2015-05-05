<?php

class Nachricht {
	
	public function getInhalt(){
		return "Dummy-Inhalt mit #Hashtag";
	}
	
	public function getBenutzer(){
		return new Benutzer();
	}
	
	public function getDatum(){
		return new Date();
	}
	
	public function sucheNachHashtag($hashtag){
		return Array();
	}
	
}

?>