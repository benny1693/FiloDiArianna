<?php
require_once 'utilities.php';
$user = init();
$numArticles = 5;
$page = new Page();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Personaggi | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="description" content="Scopri le voci sui personaggi della mitologia greca dell'enciclopedia più ellenica del web" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, personaggi" />
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
				<li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
				<li class="breadcrumb-item active" aria-current="page">Personaggi</li>
			</ol>
		</nav>
		<section>
			<h1>Personaggi</h1>
            <a href="#macrocategories" class="sr-only">Salta introduzione</a>
            <p>La mitologia greca &egrave; piena di personaggi iconici e notissimi nella cultura popolare: basti pensare a Zeus, il padre degli Dei, o ad Eracle e le sue dodici fatiche. Tuttavia, individuare una perfetta suddivisione in categorie &egrave; un compito davvero spinoso: si prenda ad esempio le Creature. Molte di loro sono figlie di alcune divinit&agrave;: sono, quindi, delle semidivinit&agrave; o delle creature? Cionnonostante, abbiamo cercato di suddividere in categorie tali personaggi.</p>
            <dl>
                <dt>Esseri Umani</dt>
                <dd>Sono tutti quei personaggi che non sono di discendenza divina, ma hanno partecipato a degli eventi della mitologia</dd>
                <dt>Semidivinit&agrave; ed Eroi</dt>
                <dd>Sono tutti quei personaggi frutto dell'unione tra dei e uomini e che spesso popolano le leggende pi&ugrave; note della mitologia greca.</dd>
                <dt>Divinit&agrave;</dt>
                <dd>Sono tutti quei personaggi di esclusiva discendenza divina.</dd>
                <dt>Creature</dt>
                <dd>Sono tutte quelle entit&agrave; dall'aspetto non antropomorfo.</dd>
            </dl>
            <p>Per ogni categoria puoi visulizzare alcuni articoli appartenenti.</p>
            <ul id="macrocategories">
				<li>
					<a href="#semidei" class="sr-only">Salta lista</a>
					<h2><a href="ricerca.php?category=personaggi&subcategory=umani">Esseri Umani</a></h2>
					<ul class="categories">
                        <?php
                        $list = $user->searchArticle('','personaggi','umani');
                        $page->printRandomArticlesTitle($list,$numArticles);
                        ?>
					</ul>
				</li>

				<li id="semidei">
					<a href="#dei" class="sr-only">Salta lista</a>
					<h2><a href="ricerca.php?category=personaggi&subcategory=eroi">Semidivinit&agrave; ed Eroi</a></h2>
					<ul class="categories">
                        <?php
                        $list = $user->searchArticle('','personaggi','eroi');
                        $page->printRandomArticlesTitle($list,$numArticles);
                        ?>
					</ul>
				</li>

				<li id="dei">
					<a href="#creature" class="sr-only">Salta lista</a>
					<h2><a href="ricerca.php?category=personaggi&subcategory=dei">Divinit&agrave;</a></h2>
					<ul class="categories">
                        <?php
                        $list = $user->searchArticle('','personaggi','dei');
                        $page->printRandomArticlesTitle($list,$numArticles);
                        ?>
					</ul>
				</li>

				<li id="creature">
					<a href="#scroll-back-button" class="sr-only">Salta lista</a>
					<h2><a href="ricerca.php?category=personaggi&subcategory=creature">Creature</a></h2>
					<ul class="categories">
                        <?php
                        $list = $user->searchArticle('','personaggi','creature');
                        $page->printRandomArticlesTitle($list,$numArticles);
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
