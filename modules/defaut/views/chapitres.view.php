<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue de la liste des chapitres
 *
 * File Last Update : 2017 10 03
 *
 * File Description :
 * -> affiche la liste des publications
 */
//------------------------------------------------------------
// HTML
?>

<section>

	<!-- AFFICHAGE DE LA LISTE DES PUBLICATIONS -->
	<div class="row">
		<?php if (empty($billets)) : ?>
			<div class="col-xs-12">
				<p>Aucun chapitre publié</p>
			</div>
		<?php else : ?>
			<?php foreach ($billets as $billet) : ?>
				<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-xs-12">
							<div class="col-sm-4">
								<?php if (!is_null($billet->get_image())) : ?>
									<img src="<?= $billet->get_image(); ?>" class="img-responsive" alt="Responsive image" />
								<?php endif; ?>
							</div>
							<div class="col-sm-8">
								<h3><a href="?page=billet&id=<?= $billet->get_id(); ?>"><?= $billet->get_titre(); ?></a></h3>
								<p>Publié le <?= $billet->get_date_publie(); ?></p>
								<span class=""><a href="?page=billet&id=<?= $billet->get_id(); ?>" type="button" class="btn btn-default" aria-label="billet">Lire le chapitre <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></span>
							</div>
						</div>
					</div>
				</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

</section>