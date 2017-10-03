<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue d'un billet
 *
 * File Last Update : 2017 09 22
 *
 * File Description :
 * -> affiche un billet
 */
//------------------------------------------------------------
// HTML
?>

<section>

	<!-- AFFICHAGE DU BILLET -->
	<h6 class="text-right">Publié le <?= $billet->get_date_modif(); ?></h6>
	<?php if (!is_null($billet->get_image())) : ?>
		<img src="<?= $billet->get_image(); ?>" class="img-responsive" alt="<?= $billet->get_titre(); ?>" />
	<?php endif; ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3><?= $billet->get_titre(); ?></h3>
		</div>
		<div class="panel-body"><?= $billet->get_contenu(); ?></div>
		<div class="panel-footer text-center">
			<?= (is_null($auteur->get_prenom()) OR is_null($auteur->get_nom())) ? $auteur->get_pseudo() : $auteur->get_prenom() . ' ' . $auteur->get_nom(); ?>
		</div>
	</div>

</section>