<?php
require_once 'utilities.php';
$user = init();

$page = new FormPage(false);

if ($user->isRegistered()) {
	$_SESSION['errorMsg'] = 'Hai gi&agrave; effettuato l\'accesso';
	header("Location: avviso.php");
	exit();
} else {
	if (!empty($_POST)){
		$user = login($_POST['username'], $_POST['password']);
	    $page->setErrors(!$user->isRegistered());
        if (!$page->hasErrors()){
            header("Location: ../index.php");
            exit();
        }
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Pagina di accesso | Filo di Arianna</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Laura Cameran" />
	<meta name="description" content="Accedi al tuo profilo o registrati." />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, accesso, login, sign-up, sign-in" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
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
				<li class="breadcrumb-item active" aria-current="page">Accesso</li>
			</ol>
		</nav>

        <section id="accesso">
            <h1>Accedi</h1>
            <a href="registrazione.php" class="sr-only">Salta alla registrazione</a>
            <form data-toggle="validator" action="accesso.php" method="post">
                <div class="form-group row">
                    <label for="inputUsername0" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputUsername0" name="username" placeholder="Username" required="required" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword0" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword0" name="password" placeholder="Password" required="required" />
                        <?php
                        if ($page->hasErrors())
                            $page->printFeedback('Username o password errati',false);
                        ?>
                    </div>
                </div>
                <div class="form-group row col-sm-10 col-sm-offset-3">
                    <button type="submit" class="btn  btn-outline-primary">Vai</button>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-3">
                    <p id="NonAncoraRegistrato">Non sei ancora registrato?</p>
                    <a href="registrazione.php" class="btn btn-outline-primary">Registrati</a>
                </div>
            </div>
        </section>
	</div>

	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
