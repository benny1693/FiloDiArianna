<?php
include_once 'utilities.php';
$user = init();
$articleID = $_GET['articleID'];
$instime = $_GET['instime'];
$infoArticle = $user->getArticleInfo($articleID);
if($articleID == null || $infoArticle == null || $instime) { //se la pagina non esiste o l'id non corrisponde o la pagina è pendente
    header("Location: notfound.php");
    exit();
}

$article = new ArticlePage($articleID, $infoArticle['title'], $infoArticle['author'], $infoArticle['img'], $infoArticle['ext'], $infoArticle['content']);

$comments = $user->getArticleComment($article->getArticleID()); //per ricevere tutti i commenti relativi a quell'articolo dal DB

$categories = $user->getPathArticle($articleID);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Discussione su <?php echo $article->getTitle(); ?> | Il Filo di Arianna</title>
	<meta name="description" content="Discussione tra gli utenti sull'articolo TitoloArticolo" />
	<meta name="keywords" content="Filo, Arianna, greco, mitologia, TitoloArticolo, discussione" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js">
	</script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php'; ?>

	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $categories[2]; ?>.php"><?php echo $categories[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="ricerca.php?category=<?php echo $categories[2]; ?>&subcategory=<?php echo $categories[3]; ?>"><?php echo $categories[1]; ?></a></li>
				<li class="breadcrumb-item"><a href="articolo.php?articleID=<?php echo $article->getArticleID(); ?>"><?php echo $article->getTitle(); ?></a></li>
				<li class="breadcrumb-item" aria-current="page">Discussione</li>
			</ol>
		</nav>

		<section id="discussione">
			<ul id="article-menu">
				<li><a href="articolo.php?articleID=<?php echo $article->getArticleID(); ?>">Voce</a></li>
				<li class="active">Discussione</li>
			</ul>
			<div id="article-content">
				<div id="article-title">
					<h1>Discussione di <?php echo $article->getTitle(); ?></h1>
					<p id="article-id"><?php echo $article->getArticleID(); ?></p>
                    <a id="back-to-article" href="articolo.php?articleID=<?php echo $article->getArticleID(); ?>">Torna all'articolo</a>
				</div>

				<div id="commentlist">
                    <?php $article->printArticleComments($comments); //per inserire in commenti nell'area discussione relativa ?>
				</div>

                <?php
                //se l'utente non è registrato, non può lasciare un commento quindi non vede la textarea
                if($user->isRegistered())
                    $article->showTextArea($_SESSION['commenterror']);

                unset($_SESSION['commenterror']);
                ?>

			</div>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
