<?php
	include "connessione.php"; // inclusione del file di connessione
	echo file_get_contents("inizio.txt");//stampo l’inizio pagina
	if (!$result = $connessione->query("SELECT * FROM raccolte")) {
			echo "Errore della query: " . $connessione->error . ".";
			exit();
		} else { // stampa dei record nella tabella
		if($result->num_rows > 0) {
			//ciclo while per la stampa delle righe della tabella
			$result->free(); // liberaz. risorse occupate dalla query
		} echo "</tbody></table>";
	}
	$connessione->close(); // chiusura della connessione
	echo file_get_contents("pagine/fine.txt"); //fine pagina
