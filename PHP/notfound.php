<?php
require_once 'utilities.php';
init();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<meta charset="utf-8" />
	<title>Oooops! | Filo di Arianna</title>
	<meta name="description" content="Pagina di errore per dati non trovati" />
	<meta name="keywords" content="Filo, Arianna, ops, not, found, perso, greco, mitologia" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body id="not-found">

    <?php include_once 'header.php';?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ti sei perso</li>
			</ol>
		</nav>
		<section>
			<h1><span lang="el">Ὀτοτοῖ!</span> Qualcosa non va...</h1>
			<p>Accidenti, sembra che tu sia rimasto impigliato e che ti sia perso! Prova a tornare alla <a href="../index.php" lang="en">Home</a> e riprova da l&igrave;!</p>
		</section>
	</div>
	<?php include_once '../HTML/footer.html';?>
</body>

</html>
