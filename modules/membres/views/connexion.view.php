<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la connexion
 *
 * File Last Update : 2017 07 25
 *
 * File Description :
 * -> affiche le formulaire de connexion
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */
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