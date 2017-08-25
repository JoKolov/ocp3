<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la connexion
 *
 * File Last Update : 2017 08 24
 *
 * File Description :
 * -> affiche le formulaire de connexion
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

//------------------------------------------------------------
// Génération des valeurs à afficher
set_view_var();
$var = $_SESSION['view_var'];


//------------------------------------------------------------
// HTML
?>
<section>

	<div class="row">
		<div class="col-sm-12">
			<h3>Connexion</h3>
			<?php
				/**
				 * Affichage des erreurs
				 */
				if (isset($var['error']))
				{
				 	echo $var['error']['error'];
				}
			?>
		</div>
	</div>

	<form method="post" action="?module=membres&action=connexion" class="form-horizontal">
	
		<div class="form-group">
			<label for="pseudo" class="col-sm-2 control-label"><?= $var['label']['pseudo']; ?></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="<?= $var['placeholder']['pseudo']; ?>" name="pseudo" id="pseudo">
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label"><?= $var['label']['password']; ?></label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="<?= $var['placeholder']['password']; ?>" name="password" id="password">
			</div>
		</div>

		<div class="">
			<button type="submit" class="btn btn-primary btn-block">Connexion</button>
			<a href="index.php?module=membres&page=inscription" class="btn btn-default btn-block">Créer un compte <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>
			
	</form>

</section>