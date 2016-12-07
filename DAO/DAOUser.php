<?php

/**
 * Created by PhpStorm.
 * User: andreas.blonske
 * Date: 16.11.2016
 * Time: 11:14
 */
class DAOUser
{
	var $connection;
	
		function DAOUser($connection2) {
			$this->connection = $connection2;
		}

        function getUserById($id) {
        	
        	
            //SQL Befehl: Hole "alle" Eintr�ge (Zeilen) aus der Tabelle "user" die in der Spalte id die �bergebene $id haben - d�rfte eigentlich nur ein Benutzer sein :-)
        	$sql = "SELECT * FROM benutzer WHERE idBenutzer='".$id."'";

            $result = $this->connection->query($sql);

            if (!$result) {
            	echo "DB Fehler getUserById ".mysql_error($this->connection);
            }

            while ($row = $result->fetch_assoc()) {
				$tmpUser = new CUser();	//neues Objekt der Klasse CUser
				//Hole aus dem Eregbnisarray die Inhalte anhand der Schl�ssel und speichere sie in das Objekt
				$tmpUser->setId($row['idBenutzer']);
				$tmpUser->setName($row['benutzerName']);
				//usw
				
				//gib das Objekt dem aufrufenden Befehl zur�ck
				return $tmpUser;
            }
            
            //falls kein Eintrag gefunden wird. Gib null zur�ck
            return null;
        }
        
        function getUserByZugangsdaten($benutzername, $pwd) {        	 
        	 
        	$sql = "SELECT * FROM user 
        					WHERE 	benutzername='".$benutzername."' 
        						AND	pwd = '".$pwd."'";
        
        	$result = $this->connection->query($sql);
        
        	if (!$result) {
        		echo "DB Fehler getUserByZugangsdaten ".mysql_error($this->connection);
        	}
        
        	while ($row = $result->fetch_assoc()) {
        		$tmpUser = new CUser();	//neues Objekt der Klasse CUser
        		$tmpUser->setId($row['id']);
        		$tmpUser->setName($row['name']);
        		//usw...
        		return $tmpUser;
        	}
        
        	return null;
        }
        
        function anmeldenUSer($CUser) {
        
        	$sql = "UPDATE user SET session = '".$CUser->getSession()."' WHERE id = '".$CUser->getId()."'";
        
        	$result = $this->connection->query($sql);
        
        	if (!$result) {
        		echo "DB Fehler anmeldenUSer ".mysql_error($this->connection);
        		return 0;
        	}
        
        	return 1; //Wenn alles geklappt hat, sende "Ja" zur�ck.
        }


}