<?php
require_once 'utilities.php';
$user = init();
if (!$user->isRegistered()) {
	$_SESSION['errorMsg'] = 'Devi essere registrato per vedere questa pagina';
    header('Location: avviso.php');
    exit();
}

$pendenti = empty($_GET['adm']) ? 0 : $_GET['adm'];

$list = null;
if ($user->isAdmin())
	$list = $user->searchArticle('', null, null,$pendenti);
else {
    if ($user->isRegistered())
    	$list = $user->searchArticle('', null, null, $pendenti, $user->getID());
}

$listPage = null;
try {
	$listPage = new SearchPage(empty($_GET['page']) ? 1 : $_GET['page'], count($list));
} catch (Exception $exception) {
    header("Location: notfound.php");
    exit();
}
$listPage->setAdministration($pendenti);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Area personale | Il Filo di Arianna</title>
	<meta name="description" content="Gestisci le pagine create" />
	<meta name="keywords" content="Filo, Arianna, greco, mitologia, pagina, gestisci, pubblicata" />
	<meta name="author" content="Alessandro Spreafico" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
    <link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php'; ?>

    <div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="areapersonale.php">Area personale</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pagine <?php echo ($pendenti == 2 ? 'pendenti' : 'pubblicate'); ?></li>
			</ol>
		</nav>

		<section>
            <h1>Pagine <?php echo ($pendenti == 2 ? 'pendenti' : 'pubblicate'); ?></h1>
            <?php if ($listPage->noResults()): ?>
                <p id="results">Nessun risultato trovato</p>
            <?php else: ?>
                <p id="results">Trovati <?php echo $listPage->getArticles(); ?> risultati</p>
                <p class="sr-only">Pagina <?php echo $listPage->getIndex(); ?> di <?php echo $listPage->lastPage(); ?></p>
                <a href="#lista" class="sr-only">Salta la paginazione</a>
                <?php $listPage->printNavigation(true); ?>
                <ul id="lista" class="query">
                    <?php $listPage->printArticleList($list, $user->isAdmin()); ?>
                </ul>
                <a href="#scroll-back-button" id="bottomnav" class="sr-only">Salta la navigazione</a>
                <?php $listPage->printNavigation(true); ?>
            <?php endif; ?>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
