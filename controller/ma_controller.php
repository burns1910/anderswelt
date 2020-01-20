<?php

	function listeAllerMitarbeiter() {
		global $connection;
		$retval = array();
		$query = $connection->prepare("SELECT * FROM mitarbeiter");
    	$query->execute();
 
		$i = 0; 
    	while($result = $query->fetch(PDO::FETCH_ASSOC)) {
    		$retval[$i] = $result;
    		$i++;
    	}
	return $retval;
	}

	function listeAllerMitarbeiterShort() {
		global $connection;
		$retval = array();
		$query = $connection->prepare("SELECT id,vorname,nachname,nick,email,verified,aktiv,cvd,cvt,selector,kasse,tresenmuetze,tresen,runner,garderobe,hofmuetze,hofwache,awareness,hygiene FROM mitarbeiter");
    	$query->execute();
 
		$i = 0; 
    	while($result = $query->fetch(PDO::FETCH_ASSOC)) {
    		$retval[$i] = $result;
    		$i++;
    	}
	return $retval;
	}

	function getDataFromMitarbeiterByID($id) {
		global $connection;
    	$query = $connection->prepare("SELECT * FROM mitarbeiter WHERE ID=:id");
    	$query->bindParam("id", $id, PDO::PARAM_STR);
    	$query->execute();
 
    	$retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
	}

	function updateMitarbeiterTasks($id, $cvd, $cvt, $selector, $kasse, $tresenmuetze, $tresen, $runner, $garderobe, $hofmuetze, $hofwache, $awareness, $hygiene) {
		global $connection;
		global $message;
		$query = $connection->prepare("UPDATE mitarbeiter SET CVD = :cvd, CVT = :cvt, SELECTOR = :selector, KASSE = :kasse, TRESENMUETZE = :tresenmuetze, TRESEN = :tresen, RUNNER = :runner, GARDEROBE = :garderobe, HOFMUETZE = :hofmuetze, HOFWACHE = :hofwache, AWARENESS = :awareness, HYGIENE = :hygiene WHERE id = :id");
	    $query->bindParam("id", $id, PDO::PARAM_STR);
	    $query->bindParam("cvd", $cvd, PDO::PARAM_STR);
	    $query->bindParam("cvt", $cvt, PDO::PARAM_STR);
	    $query->bindParam("selector", $selector, PDO::PARAM_STR);
	    $query->bindParam("kasse", $kasse, PDO::PARAM_STR);
	    $query->bindParam("tresenmuetze", $tresenmuetze, PDO::PARAM_STR);
	    $query->bindParam("tresen", $tresen, PDO::PARAM_STR);
	    $query->bindParam("runner", $runner, PDO::PARAM_STR);
	    $query->bindParam("garderobe", $garderobe, PDO::PARAM_STR);
	    $query->bindParam("hofmuetze", $hofmuetze, PDO::PARAM_STR);
	    $query->bindParam("hofwache", $hofwache, PDO::PARAM_STR);
	    $query->bindParam("awareness", $awareness, PDO::PARAM_STR);
	    $query->bindParam("hygiene", $hygiene, PDO::PARAM_STR);
	    $result = $query->execute();

	    if ($result) {
	        $message = '<p class="aw-success-message">&Auml;nderungen erfolgreich gespeichert.</p><br />';
	    } else {
	        $message = '<p class="aw-error-message">&Auml;nderungen konnten nicht gespeichert werden.</p><br />';
	    }
	}

	function activateDeactivateMitarbeiter($id, $status) {
		global $connection;
		global $message;
		$query = $connection->prepare("UPDATE mitarbeiter SET AKTIV = :aktiv WHERE id = :id");
	    $query->bindParam("id", $id, PDO::PARAM_STR);
	    $query->bindParam("aktiv", $status, PDO::PARAM_STR);
	    $result = $query->execute();

	    if ($result) {
	        $message = '<p class="aw-success-message">&Auml;nderungen erfolgreich gespeichert.</p><br />';
	    } else {
	        $message = '<p class="aw-error-message">&Auml;nderungen konnten nicht gespeichert werden.</p><br />';
	    }
	}


?>