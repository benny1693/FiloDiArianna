<?php
include_once 'utilities.php';
$user = init();

$articleID = $_GET['articleID'];
if($articleID == null || $user->getArticleInfo($articleID) == null) { //se la pagina non esiste o l'id non corrisponde
    header("Location: notfound.php");
    exit();
}
$infoArticle = $user->getArticleInfo($articleID);
$article = new ArticlePage($articleID, $infoArticle['title'], $infoArticle['author'], $infoArticle['img'],$infoArticle['ext'], $infoArticle['content']);
$instime = null;

// Se sono l'autore dell'articolo o l'admin sono un utente corretto
$correctUser = ($user->isRegistered() && $user->getID() == $article->getAuthor()) || $user->isAdmin();
$instime = $correctUser ? $_GET['instime'] : null;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
    <?php echo '
	<title>'.$article->getTitle().' | Il Filo di Arianna</title>';
	?>
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
				<li class="breadcrumb-item" aria-current="page"><?php echo $article->getTitle(); ?></li>
			</ol>
		</nav>
		<section id="articolo">
            <?php
                //if($articleID == null)
            ?>
			<ul id="article-menu">
				<li class="active">Voce</li>
                <?php
                if(!($user->isPendentPage($articleID, $instime))){
                    echo '<li><a href="discussione.php?articleID='.$articleID.'">Discussione</a></li>';
                }
                ?>
			</ul>

			<div id="article-content">

				<div id="article-title">
                    <?php
                    $authorInfo = $user->getOtherUserInfo($article->getAuthor());
                    echo '
					<h1>' . $article->getTitle() . '</h1>
					<p id="article-id">'.$article->getArticleID().'</p>
					<p id="article-author">Scritto da <a href="profilopubblico.php?ID='.$article->getAuthor().'">'.$authorInfo['username'].'</a></p>'
				    ?>
                </div>

				<div id="article-body">
					<figure id="article-image">
                        <?php
						$base64 = 'data:image/' . $article->getImageExtension() . ';base64,' . base64_encode($article->getImage());
						echo '<img class="img-fluid" src="'.$base64.'" alt="Immagine di TitoloArticolo" />'
						?>
					</figure>
					<p>
                        <?php
                        echo $article->getContent();
                        ?>
					</p>
				</div>

				<div id="article-references">
                    <h2>Pagine correlate</h2>
                    <?php
                    $relatedPages = $user->getRelatedPages($article->getArticleID(),$instime);

                    if ($instime) {
                        echo '<h3>Pagine correlate alla versione pubblicata</h3>';
                        $user->printRelatedPages($relatedPages['posted']);
                        echo '<h3>Pagine correlate a questa versione</h3>';
                        $user->printRelatedPages($relatedPages['unposted']);

                    } else {
                        $user->printRelatedPages($relatedPages);
                    }
                    ?>
					</ul>
				</div>
			</div>

		</section>
	</div>
    <!-- FOOTER -->
    <?php include_once '../HTML/footer.html';?>
</body>

</html>
