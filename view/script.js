var mach_nochmal = null;
/**
 * 
 */
function sucheHashtag(hashtag, displayElem){
	if (hashtag.substring(0,1) == "#"){
		hashtag = hashtag.substring(1);
	}
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/hashtag/"+hashtag, true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(displayElem).innerHTML = formatiereNachrichten(JSON.parse(req.responseText));
		}
	};
	req.send();	
	wiederhole(function(){sucheHashtag(hashtag, displayElem)});
}

function wiederhole(funktion){
	if (mach_nochmal != null){
		clearInterval(mach_nochmal);
	}
	mach_nochmal = setInterval(funktion, 60000);
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
				zeigeTimeline(nachrichtenElem);
			}
		}
	};
	req.send();			
}

function folgenEingabe(self, e, folgenElem, nachrichtenElem) {
	if (e.keyCode == 13) {
		folgeBenutzer(self.value, folgenElem, nachrichtenElem)
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
	wiederhole(function(){zeigeTimeline(displayElem)});
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
	function zwst(x){
		if (x < 10){
			return "0" + x;
		} else {
			return x;
		}
	}
	var res = "";
	for (var i=0; i<nachrichten.length; i++){
		nachricht = nachrichten[i];
		var datum = new Date(nachricht["datum"]*1000);
		var monate = new Array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "Septemer", "Oktober", "November", "Dezember");
		var datumStr = zwst(datum.getDate()) + ".&nbsp;" + monate[datum.getMonth()] + "&nbsp;" + datum.getFullYear() + " " + zwst(datum.getHours()) + ":" + zwst(datum.getMinutes());
		res += '<div class="nachricht"><div class="nachrichtHeader"><span class="nachrichtName">'+nachricht["benutzer"]["vorname"]+" "+nachricht["benutzer"]["nachname"]+'</span><span class="nachrichtNickname">'+nachricht["benutzer"]["nickname"]+'</span><span class="nachrichtDatum">'+datumStr+'</span></div><div class="nachrichtBody">'+nachricht["inhalt"]+'</div></div>';
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