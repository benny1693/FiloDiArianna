<?php
require_once "utilities.php";
$user= init();
$list = $user->searchArticle($_GET['substringSearched'], $_GET['category'], $_GET['subcategory']);

$listPage = null;
try {
	$listPage = new SearchPage(empty($_GET['page']) ? 1 : $_GET['page'], count($list));
} catch (Exception $exception) {
	header("Location: notfound.php");
	exit();
}

$from_scopri = !empty($_GET['category']) && !empty($_GET['subcategory']) && $_GET['category'] != 'not_selected';
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
                <?php
                $categories = $user->findTypeReadFormat($_GET['category'],$_GET['subcategory']);

                if ($categories && User::isValidCategory($_GET['category'])){
                    echo '
                <li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>';
                    if(!empty($_GET['subcategory']) && User::isValidSubcategory($_GET['subcategory'])) {
                        echo '
                    <li class="breadcrumb-item"><a href="' . $_GET['category'] . '.php">' . $categories[0] . '</a></li>
                    <li class="breadcrumb-item active" aria-current="page" >' . $categories[1] . '</li>';
                    } else {
                        echo '
                    <li class="breadcrumb-item active">' . $categories[0] . '</li>';
                    }
                } else {
                    echo '<li class="breadcrumb-item active" aria-current="page">Ricerca</li>';
                }

                ?>
			</ol>
		</nav>
		<section>
			<h1>Risultati di ricerca</h1>
            <?php
            $emptysearch = $_GET['substringSearched'] == null && !$from_scopri;
            if($emptysearch || empty($list))
                echo '<p id="results">Nessun risultato trovato</p>';
            else {
                echo "<p id=\"results\">Trovati " . $listPage->getArticles() . " risultati</p>";
                echo '<p class="sr-only">Pagina '. $listPage->getIndex() .' di '. $listPage->lastPage() .'</p>';

                $listPage->printNavigation();

                echo '<ul class="query">';

                $listPage->printArticleList($list);

                echo '</ul>';

                $listPage->printNavigation();
            }
            ?>
        </section>
	</div>
	<!--FOOTER-->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
