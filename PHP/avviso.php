<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 12/02/19
 * Time: 1.36
 */
require_once 'utilities.php';
$user = init();
$page = new Page();
if (!$_SESSION['errorMsg'] && !$_SESSION['successMsg']){
    header('Location: notfound.php');
    exit();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Avviso | Filo di Arianna</title>
	<meta charset="UTF-8" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="robots" content="noindex" />	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
<!-- HEADER -->
<?php include_once 'header.php';?>
<div id="page-content-wrapper" class="container-fluid">
	<nav aria-label="breadcrumb">
		<p class="sr-only">Ti trovi in:</p>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Avviso</li>
		</ol>
	</nav>
	<section>
	<?php
	if (isset($_SESSION['errorMsg']))
		$page->printFeedback($_SESSION['errorMsg'],false);
	elseif(isset($_SESSION['successMsg']))
		$page->printFeedback($_SESSION['successMsg'],true);
	unset($_SESSION['errorMsg']);
	unset($_SESSION['successMsg']);
	?>
	</section>
</div>
<!-- FOOTER -->
<?php include_once '../HTML/footer.html'; ?>
</body>
</html>