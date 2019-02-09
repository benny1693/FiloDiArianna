<?php
include_once 'utilities.php';
$user = init();

$articleID = $_GET['articleID']; //se tutto funzia
$infoArticle = $user->getArticleInfo($articleID);
$article = new ArticlePage($articleID, $infoArticle['title'], $infoArticle['author'], $infoArticle['img'],$infoArticle['ext'], $infoArticle['content']);
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
			<ul id="article-menu">
				<li class="active">Voce</li>
				<li><a href="discussione.php">Discussione</a></li>
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
                    $relatedPages = $user->getRelatedPages($article->getArticleID());
                    if ($relatedPages){
                        echo '
					<ul>';
                        foreach ($relatedPages as $related)
                            echo '<li><a href="articolo.php?articleID='.$related['ID2'].'">'.$related['title2'].'</a></li>';
                    } else {
                        echo '<p>Nessuna pagina correlata</p>';
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