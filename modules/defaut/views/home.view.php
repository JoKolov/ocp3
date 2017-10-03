<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * THEME : Default
 * FILE/ROLE : Home page
 *
 * File Last Update : 2017 09 15
 *
 * File Description :
 * -> page d'accueil
 */
?>
<section>
	<div>
		<h1>Dernières Publications</h1><br />
		
		<?php if (!isset($dernierBillet)) : ?>
			<p>Jean est un écrivain très occupé. <br />
			L'écriture de son nouveau roman a débuté et il vous livrera dans les prochains jours le tout premier chapitre en exclusivité sur ce blog.</p>
		<?php else : ?>
			<!-- AFFICHAGE DU BILLET -->
			<h6 class="text-right">Publié le <?= $dernierBillet->get_date_modif(); ?></h6>
			<?php if (!is_null($dernierBillet->get_image())) : ?>
				<img src="<?= $dernierBillet->get_image(); ?>" class="img-responsive" alt="Responsive image" />
			<?php endif; ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?= $dernierBillet->get_titre(); ?></h3>
				</div>
				<div class="panel-body"><?= $dernierBillet->get_extrait(); ?><br />
					<span class="pull-right">
						<a href="?page=billet&id=<?= $dernierBillet->get_id(); ?>" type="button" class="btn btn-info" aria-label="billet">Lire le chapitre <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
					</span>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<?php foreach ($billets as $billet) : ?>
			<div class="col-sm-4">
				<?php if (!is_null($billet->get_image())) : ?>
					<img src="<?= $billet->get_image(); ?>" class="img-responsive" alt="Responsive image" />
				<?php endif; ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3><?= $billet->get_titre(); ?></h3>
					</div>
					<div class="panel-body"><?= $billet->get_extrait(); ?><br />
						<span class="pull-right">
							<a href="?page=billet&id=<?= $billet->get_id(); ?>" type="button" class="btn btn-info" aria-label="billet">Lire le chapitre <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
						</span>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>

		<?php if (is_null($membre)) : ?>
		<div class="row">
			<div class="col-xs-12">
				<h4>Le saviez-vous ?</h4>
				<p>Le compte abonné permet de publier ses commentaires instantanément !</p>
				<p>Créez votre compte en moins d'une minute ou connectez-vous.</p>
				<div class="btn-group" role="group">
		            <a href="?module=membres&page=connexion" type="button" class="btn btn-default" title="Se connecter"><i class="fa fa-user" aria-hidden="true"></i> Se connecter</a>
		            <a href="?module=membres&page=inscription" type="button" class="btn btn-default" title="S'inscrire"><i class="fa fa-user-plus" aria-hidden="true"></i> S'inscrire</a>
	        	</div>
        	</div>
		</div>
		<?php endif; ?>

	</div>
</section>