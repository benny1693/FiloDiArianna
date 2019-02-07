<?php
require_once 'utilities.php';
init();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Area personale | Il Filo di Arianna</title>
	<meta name="description" content="Gestisci le pagine create" />
	<meta name="keywords" content="Filo, Arianna, greco, pagina, gestione, area, personale" />
	<meta name="author" content="Alessandro Spreafico" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php';?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Area personale</li>
			</ol>
		</nav>
		<section>
            <?php
            if ($_SESSION['ID'] == -1)
                echo "<div class=\"invalid-feedback\">
					<p>Non hai effettuato l'accesso</p>
				</div>";
            else {
			echo '<h1>Area personale</h1>
			<h2>Dati personali</h2>
			<dl id="personalia">
				<dt>Nome</dt>
				<dd>Ciccio</dd>
				<dt>Cognome</dt>
				<dd>Pasticcio</dd>
				<dt>Data di nascita</dt>
				<dd>01/01/2001</dd>
				<dt>Occupazione</dt>
				<dd>Pasticcio</dd>
			</dl>

			<h2>Funzionalit&agrave;</h2>
			<ul id="collegamentibottoni">
				<li> <a href="nuovapagina.php">Crea una nuova pagina</a> </li>
				<li> <a href="paginependenti.html">Pagine pendenti</a> </li>
				<li> <a href="listapagine.php">Pagine pubblicate</a> </li>
				<li> <a href="gestioneutenti.php">Gestione utenti</a> </li>
			</ul> ';
            }
            ?>
		</section>
	</div>

	<!-- FOOTER di Matteo -->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>


<!--NOTE 
La visualizzazione e le funzionalità  disponibili della pagina cambiano in base all'utente:

ADMIN:
1)In PAGINE PENDENTI:
vede tutte le pagine che hanno bisogno di approvazione e può accettarle o no(in questo caso viene inviata una mail a chi l'aveva creata per dirgli il perchè)
2)In PAGINE PUBBLICATE:
vede tutte le pagine pubblicate e può eliminarle (in questo caso viene inviata una mail a chi l'aveva creata per dirgli il perchè)

UTENTE:
1)In PAGINE PENDENTI:
vede le pagine che ha creato che attendono approvazione da parte di un admin, può in tempo reale eliminarle o modificarle
2)In PAGINE PUBBLICATE:
vede le pagine che ha creato che sono state pubblicate, può eliminarle o modicarle
Una modifica per essere visibile ha bisogno di approvazione, cioè:
la pagina attuale rimane tra le pagine  pubblicate, ma viene creata una copia con le modifiche apportate sulle pagine pendenti,
se la pagina pendente viene accettata essa sostituisce la versione precedente sulle pagine pubblicate.
Una eliminazione non richiede autorizazioni.
 -->
