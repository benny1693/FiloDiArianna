<?php //Connessione al DBMS e selezione del database.
// definizione parametri di connessione
$host = tecweb2016.studenti.math.unipd.it;
$user = "lcameran";
$password = "";
$db = 
// stringa di connessione al DBMS e
//creazione istanza della classe MySQLi
$connessione = new mysqli($host, $user, $password, $db);
// verifica su eventuali errori di connessione
if ($connessione->connect_errno) {
echo "Connessione fallita (". $connessione->connect_errno
. "): " . $connessione->connect_error;
exit();
}
