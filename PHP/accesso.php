<!DOCTYPE html>
<html lang="it">

<head>
	<meta name="title" content="Accesso | Filo di Arianna" />
	<title>Pagina di accesso | Filo di Arianna</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Accedi al tuo profilo o registrati." />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, accesso, login, sign-up, sign-in" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/aiuti_nav.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/provelaura.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER -->
	<?php require_once "header.php" ?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Accesso</li>
			</ol>
		</nav>

		<section id="accesso">
			<h1>Accedi</h1>

			<form class="needs-validation clearfix" method="post" novalidate>
				<div class="form-group row">
					<label for="inputUsername0" class="col-sm-3 col-form-label">Username</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="inputUsername0" placeholder="Username" required>
					</div>
					<!-- <input type="text" class="form-control is-invalid" id="validationServerUsername" placeholder="Username" aria-describedby="inputGroupPrepend3" required> -->
				</div>

				<div class="form-group row">
					<label for="inputPassword0" class="col-sm-3 col-form-label">Password</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="inputPassword0" placeholder="Password">
					</div>
				</div>
				<div class="invalid-feedback">
					<p>Inserisci password o username validi.</p>
				</div>

				<div class="form-group row col-sm-10 col-sm-offset-3 form-check">
					<input class="form-check-input" type="checkbox" id="gridCheck1">
					<label class="form-check-label" for="gridCheck1">Ricorda le mie credenziali.</label>
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
	<?php require_once "footer.html" ?>
</body>

</html>
