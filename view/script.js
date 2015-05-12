/**
 * 
 */
function sucheHashtag(hashtag, displayElem){
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/hashtag/"+hashtag, true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(displayElem).innerHTML = formatiereNachrichten(JSON.parse(req.responseText));
		}
	};
	req.send();	
}

function sucheingabe(self, e, displayElem){
	if (e.keyCode == 13){
		sucheHashtag(self.value, displayElem)
	}
}

function folgeBenutzer(benutzername, folgenElem) {
	console.log("folge benutzer " + benutzername);
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/folgen/"+benutzername, true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			console.log(req.responseText);
			if (req.responseText == "+ok") {
				zeigeGefolgte(folgenElem);
			}
		}
	};
	req.send();			
}

function folgenEingabe(self, e, folgenElem) {
	if (e.keyCode == 13) {
		folgeBenutzer(self.value, folgenElem)
	}
}

function zeigeTimeline(displayElem){
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/gefolgt/nachrichten", true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(displayElem).innerHTML = formatiereNachrichten(JSON.parse(req.responseText));
		}
	};
	req.send();		
}

function zeigeGefolgte(anzeigeElem){
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/gefolgt/benutzer", true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(anzeigeElem).innerHTML = formatiereBenutzer(JSON.parse(req.responseText));
		}
	};
	req.send();		
}

function formatiereNachrichten(nachrichten){
	var res = "";
	for (var i=0; i<nachrichten.length; i++){
		nachricht = nachrichten[i];
		res += '<div class="nachricht"><div class="nachrichtHeader"><span class="nachrichtName">'+nachricht["benutzer"]["vorname"]+" "+nachricht["benutzer"]["nachname"]+'</span><span class="nachrichtNickname">'+nachricht["benutzer"]["nickname"]+'</span><span class="nachrichtDatum">'+nachricht["datum"]["date"]+'</span></div><div class="nachrichtBody">'+nachricht["inhalt"]+'</div></div>';
	}
	return res;
}

function formatiereBenutzer(benutzers){
	var res = "";
	for (var i=0; i<benutzers.length; i++){
		benutzer = benutzers[i];
		res += '<div class="benutzer"><span class="benutzerName">'+benutzer["vorname"]+" "+benutzer["nachname"]+'</span><span class="benutzerNickname">'+benutzer["nickname"]+'</span>';
	}
	return res;
}