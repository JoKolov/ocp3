<?php



?>
<section class="container">
	<form method="post" action="connexion.mod.php" class="row">
		<h3>Connexion</h3>
		<p>
			<input type="text" class="form-control" placeholder="login" name="login" id="login">
		</p>
		<p>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
		</p>
		<p>
			<button type="button" class="btn btn-default">Valider</button>
		</p>
	</form>
	<div class="row">
		<p class="text-right">
			Pas encore de compte ? ..... <a href="index.php?module=membres&page=inscription">Inscris-toi vite !</a>
		</p>
	</div>
</section>