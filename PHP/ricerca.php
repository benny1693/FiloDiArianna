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

                if ($categories && User::isValidCategory($_GET['category'])):
                ?>
                <li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
                    <?php if (!empty($_GET['subcategory']) && User::isValidSubcategory($_GET['subcategory'])): ?>
                        <li class="breadcrumb-item"><a href="<?php echo $_GET['category']; ?>.php"><?php echo $categories[0]; ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page" ><?php echo $categories[1]; ?></li>
                    <?php else: ?>
                            <li class="breadcrumb-item active"><?php echo $categories[0]; ?></li>
                    <?php endif;?>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">Ricerca</li>
                <?php endif; ?>
			</ol>
		</nav>
		<section>
			<h1>Risultati di ricerca</h1>
            <?php
            $emptysearch = $_GET['substringSearched'] == null && !$from_scopri;
            if($emptysearch || empty($list)):
            ?>
                <p id="results">Nessun risultato trovato</p>
            <?php else: ?>
                <p id="results">Trovati <?php echo $listPage->getArticles(); ?> risultati</p>
                <p class="sr-only">Pagina <?php echo $listPage->getIndex() ?> di <?php echo $listPage->lastPage(); ?></p>

                <?php $listPage->printNavigation(); ?>

                <ul class="query">

                <?php $listPage->printArticleList($list); ?>

                </ul>

                <?php $listPage->printNavigation(); ?>
            <?php endif; ?>
        </section>
	</div>
	<!--FOOTER-->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
