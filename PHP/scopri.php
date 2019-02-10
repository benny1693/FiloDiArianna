<?php
require_once "utilities.php";
$user = init();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Scopri | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="description" content="Scopri le voci sulla mitologia greca dell'enciclopedia più ellenica del web" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER -->
    <?php include_once "header.php";?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Scopri</li>
			</ol>
		</nav>
		<h1>Scopri le voci</h1>
        <p>Per ogni sotto-categoria puoi visulizzare gli articoli più visitati!</p>
        <ul id="macrocategories">
			<li>
				<a href="#eventi" class="sr-only">Salta lista</a>
				<h2><a href="personaggi.php">Personaggi</a></h2>
				<ul>
					<li><a href="ricerca.php?category=personaggi&substringSearched=&subcategory=umani">Esseri Umani</a></li>
					<li><a href="ricerca.php?category=personaggi&substringSearched=&subcategory=eroi">Semidivinit&agrave;/Eroi</a></li>
					<li><a href="ricerca.php?category=personaggi&substringSearched=&subcategory=dei">Divinit&agrave;</a></li>
					<li><a href="ricerca.php?category=personaggi&substringSearched=&subcategory=creature">Creature</a></li>
				</ul>
			</li>

			<li id="eventi">
				<a href="#luoghi" class="sr-only">Salta lista</a>
				<h2><a href="eventi.php">Eventi</a></h2>
				<ul>
					<li><a href="ricerca.php?category=eventi&substringSearched=&subcategory=eradei">Epoca degli Dei</a></li>
					<li><a href="ricerca.php?category=eventi&substringSearched=&subcategory=eradeiuomini">Epoca degli Dei e degli Uomini</a></li>
					<li><a href="ricerca.php?category=eventi&substringSearched=&subcategory=eraeroi">Epoca degli Eroi</a></li>
				</ul>
			</li>

			<li id="luoghi">
				<a href="#scroll-back-button" class="sr-only">Salta lista</a>
				<h2><a href="luoghi.php">Luoghi</a></h2>
				<ul>
					<li><a href="ricerca.php?category=luoghi&substringSearched=&subcategory=mitologici">Mitologici</a></li>
					<li><a href="ricerca.php?category=luoghi&substringSearched=&subcategory=reali">Reali</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- FOOTER -->
	<?php include_once "../HTML/footer.html";?>
</body>

</html>
