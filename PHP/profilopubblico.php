<?php
require_once 'utilities.php';
$user = init();
$pageUserID = $_GET['ID'];
$infoUserPage = $user->getOtherUserInfo($pageUserID);
if($pageUserID == null || $infoUserPage == null) {  //se id inesistente o sbagliato quindi non presente in DB
    header("Location: notfound.php");
    exit();
}

$personalProfile = $_SESSION['ID'] == $pageUserID;
if($personalProfile){
        header("Location: areapersonale.php");
        exit();
}

//da qui, come per listapagine.php per la stampa delle pagine pubblicate dall'utente
$articleList = $user->searchArticle('', null, null, false, $pageUserID);
try {
	$listPage = new SearchPage(empty($_GET['page']) ? 1 : $_GET['page'], count($list));
} catch (Exception $exception) {
	header("Location: notfound.php");
	exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Profilo di <?php echo $infoUserPage['username'] ?> | Il Filo di Arianna</title>
	<meta name="description" content="Gestisci le pagine create" />
	<meta name="keywords" content="Filo, Arianna, greco, pagina, profilo, pubblico" />
	<meta name="author" content="Benedetto Cosentino" />
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
				<li class="breadcrumb-item active" aria-current="page">Profilo personale di <?php echo $infoUserPage['username']; ?></li>
			</ol>
		</nav>
		<section>

            <h1>Profilo di <?php echo $infoUserPage['username']; ?></h1>
            <h2>Dati personali</h2>
            <dl id="personalia">
                <dt>Nome</dt>
                <dd><?php echo stripslashes($infoUserPage['name']); ?></dd>
                <dt>Cognome</dt>
                <dd><?php echo stripslashes($infoUserPage['surname']); ?></dd>
                <dt>Data di nascita</dt>
                <dd><?php echo $infoUserPage['birthDate']; ?></dd>
                <dt>Sesso</dt>
                <dd><?php echo $infoUserPage['gender']; ?></dd>
            </dl>

            <h2>Pagine pubblicate</h2>
            <?php
            if($articleList): //l'utente ha pubblicato delle pagine ?>
                <?php $listPage->printNavigation(); ?>
                    <ul class="query">
                    <?php $listPage->printArticleList($articleList); ?>
                    </ul>
                <?php $listPage->printNavigation(); ?>
             <?php else: ?>
                <p>Nessuna pagina pubblicata</p>
             <?php endif; ?>
		</section>
	</div>

	<!-- FOOTER di Matteo -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
