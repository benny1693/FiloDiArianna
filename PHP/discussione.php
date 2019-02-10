<?php
include_once 'utilities.php';
$user = init();
$articleID = $_GET['articleID'];
//$articleID = 1; //per prove
$instime = $_GET['instime'];
$pendentPage = $user->isPendentPage($articleID, $instime);
if($articleID == null || $user->getArticleInfo($articleID) == null || $pendentPage) { //se la pagina non esiste o l'id non corrisponde o la pagina è pendente
    header("Location: notfound.php");
    exit();
}
$infoArticle = $user->getArticleInfo($articleID);
$article = new ArticlePage($articleID, $infoArticle['title'], $infoArticle['author'], $infoArticle['img'], $infoArticle['ext'], $infoArticle['content']);
$disc = $article->getDiscussionArea();
$arrayComments = $user->getArticleComment($article->getArticleID()); //per ricevere tutti i commenti relativi a quell'articolo dal DB

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Discussione su <?php echo $article->getTitle() ?> | Il Filo di Arianna</title>
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
    <?php include_once 'header.php';?>

	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
				<li class="breadcrumb-item"><a <?php echo 'href="articolo.php?articleID='.$articleID.'"'; ?>"><?php echo $article->getTitle() ?></a></li>
				<li class="breadcrumb-item" aria-current="page">Discussione</li>
			</ol>
		</nav>

		<section id="discussione">
			<ul id="article-menu">
                <?php echo'
				<li><a href="articolo.php?articleID='.$articleID.'">Voce</a></li>
				';
                ?>
				<li class="active">Discussione</li>
			</ul>
			<div id="article-content">
				<div id="article-title">
					<h1>Discussione di <?php echo $article->getTitle(); ?></h1>
					<p id="article-id"><?php echo $article->getArticleID() ?></p>
                    <?php echo'
					<a id="back-to-article" href="articolo.php?articleID='.$articleID.'">Torna all\'articolo</a>';
                    ?>
				</div>
				<div id="commentlist">
                    <?php $user->printArticleComment($arrayComments); //per inserire in commenti nell'area discussione relativa ?>
				</div>


                <?php
                //se l'utente non è registrato, non può lasciare un commento quindi non vede la textarea
                if($user->isRegistered()) {
                    echo '<form id="comment-form" onsubmit="">
					<div class="form-group row">
						<label for="inputText">Lascia un commento</label>
						<textarea id="inputText" class="form-control"></textarea>
					</div>

					<div class="form-group row">
						<button type="submit" class="btn btn-outline-primary">Invia</button>
					</div>
				</form> ';
                }

                ?>

			</div>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
