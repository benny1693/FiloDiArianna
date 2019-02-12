<?php
require_once 'utilities.php';
$user = init();
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
                printFeedback("Non hai effettuato l'accesso",false);
            else {
                $info = $user->getPersonalia();
                echo '<h1>Area personale</h1>
                <h2>Dati personali</h2>
                <dl id="personalia">
                    <dt>Nome</dt>
                    <dd>'.$info['name'].'</dd>
                    <dt>Cognome</dt>
                    <dd>'.$info['surname'].'</dd>
                    <dt>Data di nascita</dt>
                    <dd>'.$info['birthdate'].'</dd>
                    <dt>Email</dt>
                    <dd>'.$info['email'].'</dd>
                    <dt>Sesso</dt>
                    <dd>'.($info['gender'] == 'M' ? 'Maschile' : 'Femminile').'</dd>
                </dl>';

                echo '
                <h2>Funzionalit&agrave;</h2>
                <ul id="collegamentibottoni">
                    <li> <a href="nuovapagina.php">Crea una nuova pagina</a> </li>
                    <li> <a href="listapagine.php?adm=2">Pagine pendenti</a> </li>
                    <li> <a href="listapagine.php?adm=1">Pagine pubblicate</a> </li>';
                if ($user->isAdmin())
                    echo '
                    <li> <a href="gestioneutenti.php">Gestione utenti</a> </li>';
                echo '
                </ul> ';
            }
            ?>
		</section>
	</div>

	<!-- FOOTER di Matteo -->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
