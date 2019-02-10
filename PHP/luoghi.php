<?php
require_once 'utilities.php';
$user = init();
$numArticles = 5;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Luoghi | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="description" content="Scopri le voci sugli eventi della mitologia greca dell'enciclopedia più ellenica del web" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, luoghi" />
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
			<p class="sr-only ">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
				<li class="breadcrumb-item active" aria-current="page">Luoghi</li>
			</ol>
		</nav>
		<section>
			<h1>Luoghi</h1>
            <a href="#macrocategories" class="sr-only">Salta introduzione</a>
            <p>I luoghi della mitologia greca, ovvero dove si sono svolti gli eventi, non sono meno importanti di questi ultimi o dei personaggi. Tali luoghi hanno avuto una grande influenza nell'immaginario collettivo di chi ci ha preceduto e conseguentemente influenzano il nostro. Si pensi ad esempio all'Averno, ovvero l'Oltretomba greco, rispetto alla visione cristiana dell'aldilà. Essi sono per certi concetti molto simili e non &egrave; un caso che Dante Alighieri abbia ripreso alcune figure come Minosse e Caronte nella Divina Commedia.</p>
            <dl>
                <dt>Reali</dt>
                <dd>Sono tutti quei luoghi che sono collocabili in modo pi&ugrave; o meno preciso sulle mappe geografiche</dd>
                <dt>Mitologici</dt>
                <dd>Sono tutti quei luoghi che sono presenti solo nella mitologia e che non trovano una collocazione geografica</dd>
            </dl>
            <ul id="macrocategories">
				<li>
					<a href="#reali" class="sr-only">Salta lista</a>
					<h2><a href="ricerca.php?category=luoghi&subcategory=mitologici">Mitologici</a></h2>
					<ul class="categories">
                        <?php
                        $user->printRandomArticlesTitle($numArticles,'luoghi','mitologici');
                        ?>
					</ul>
				</li>

				<li id="reali">
					<a href="#scroll-back-button" class="sr-only">Salta lista</a>
					<h2><a href="ricerca.php?category=luoghi&subcategory=reali">Reali</a></h2>
					<ul class="categories">
                        <?php
                        $user->printRandomArticlesTitle($numArticles,'luoghi','reali');
                        ?>
					</ul>
				</li>
			</ul>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
