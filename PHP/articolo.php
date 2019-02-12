<?php
include_once 'utilities.php';
$user = init();

$articleID = $_GET['articleID'];
$infoArticle = $user->getArticleInfo($articleID);
if($articleID == null || $infoArticle == null) { //se la pagina non esiste o l'id non corrisponde
	header("Location: notfound.php");
	exit();
}

// Se sono l'autore dell'articolo o l'admin sono un utente corretto
$correctUser = ($user->isRegistered() && $user->getID() == $infoArticle['author']) || $user->isAdmin();
$instime = $correctUser ? $_GET['instime'] : null;

if ($instime) // Se bisogna visualizzare una modifica, cerco con l'insTime
	$infoArticle = $user->getArticleInfo($articleID,$instime);

$article = new ArticlePage($articleID, $infoArticle['title'], $infoArticle['author'], $infoArticle['img'],$infoArticle['ext'], $infoArticle['content']);

$categories = $user->getPathArticle($articleID);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
    <title><?php echo $article->getTitle(); ?> | Il Filo di Arianna</title>
	<meta name="description" content="Articolo riguardante <?php echo $article->getTitle(); ?> all'interno della raccolta di FiloDiArianna" />
	<meta name="keywords" content="Filo, Arianna, greco, mitologia, TitoloArticolo" />
	<meta name="author" content="Benedetto Cosentino" />
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
                <li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
                <li class="breadcrumb-item"><a href="<?php echo $categories[2]; ?>.php"><?php echo $categories[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="ricerca.php?category=<?php echo $categories[2]; ?>&subcategory=<?php echo $categories[3]; ?>"><?php echo $categories[1]; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $article->getTitle(); ?></li>
			</ol>
		</nav>
		<section id="articolo">
			<ul id="article-menu">
				<li class="active">Voce</li>
                <?php
                if($instime == null) {
                    echo '<li><a href="discussione.php?articleID='.$articleID.'">Discussione</a></li>';
                }
                ?>
			</ul>

			<div id="article-content">

				<div id="article-title">
                    <?php
                    $authorInfo = $user->getOtherUserInfo($article->getAuthor());
                    ?>
					<h1><?php echo $article->getTitle(); ?></h1>
                    <p id="article-id"><?php echo $article->getArticleID(); ?></p>
					<?php if($article->getAuthor()): ?>
                        <p id="article-author">Scritto da <a href="profilopubblico.php?ID=' . $article->getAuthor() . '"><?php echo $authorInfo['username']; ?></a></p>
                    <?php else: ?>
                        <p id="article-author">Scritto da utente eliminato</p>
				    <?php endif; ?>
                </div>

				<div id="article-body">
					<figure id="article-image">
                    <?php if (!empty($article->getImage())):
                        $base64 = 'data:image/' . $article->getImageExtension() . ';base64,' . base64_encode($article->getImage());
                    ?>
                        <img class="img-fluid" src="<?php echo $base64; ?>" alt="Immagine di <?php echo $article->getArticleID();?>" />
                    <?php endif; ?>
					</figure>
					<p>
                        <?php echo $article->getContent(); ?>
					</p>
				</div>

				<div id="article-references">
                    <h2>Pagine correlate</h2>

                    <?php
                    $relatedPages = $user->getRelatedPages($article->getArticleID(),$instime);

                    if ($instime):
                    ?>
                        <h3>Pagine correlate alla versione pubblicata</h3>
                        <?php echo $article->printRelatedPages($relatedPages['posted']); ?>
                        <h3>Pagine correlate a questa versione</h3>
                        <?php echo $article->printRelatedPages($relatedPages['unposted']); ?>

                    <?php
                    else:
                        echo $article->printRelatedPages($relatedPages);
                    endif;
                    ?>

				</div>
			</div>

		</section>
	</div>
    <!-- FOOTER -->
    <?php include_once '../HTML/footer.html';?>
</body>

</html>