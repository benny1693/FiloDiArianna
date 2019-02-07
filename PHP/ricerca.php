<?php
require_once "utilities.php";
$u = init();
$currentpage = $_GET['page'] = empty($_GET['page']) ? 1 : $_GET['page'];

$articlesNumber = 1;

$list = $u->searchArticle($_GET['substringSearched'], $_GET['category'], $_GET['subcategory']);
$pages = ceil(count($list)/$articlesNumber);

if (($currentpage - 1)*$articlesNumber > count($list) || $currentpage <= 0)
    header("Location: notfound.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<meta charset="utf-8" />
	<!-- Questa pagina di ricerca non la si vuole indicizzare -->
	<meta name="robots" content="noindex" />
	<meta name="author" content="Matteo Ranzato" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Risultati ricerca | Filo di Arianna</title>
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!--HEADER-->
    <?php include_once 'header.php'; ?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in: </p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item" lang="en"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page" lang="en">Ricerca</li>
			</ol>
		</nav>
		<section>
			<h1>Risultati di ricerca</h1>
            <?php
            if (!$list || count($list) <= 0)
                echo '<p id="results">Nessun risultato trovato</p>';
            else {
                echo "<p id=\"results\">Trovati " . count($list) . " risultati</p>";
                echo "<p class='sr-only'>Pagina $currentpage di $pages</p>";
            }

            if (count($list) > 0)
                printNavigation($currentpage,$pages);

            if ($currentpage != $pages)
                $u->printArticleList($list,($currentpage-1)*$articlesNumber,$currentpage*$articlesNumber);
            else
                $u->printArticleList($list,($currentpage-1)*$articlesNumber,count($list));

            if (count($list) > 0)
                printNavigation($currentpage,$pages);
            ?>
        </section>
	</div>
	<!--FOOTER-->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
