<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page compte membre
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> affiche le tableau de bord du compte utilisateur
 * -> informations sur le compte
 * -> outils et services disponibles
 */
//------------------------------------------------------------
// HTML
?>
<section>
	<div>
		<h1>Mon compte <?= $membre->get_type(); ?></h1>

		<p>&nbsp;</p>

		<div class="col-sm-4 text-center">
			<div class="compte-avatar" style="background-image: url('<?= $membre->get_avatar(); ?>');"></div>
		</div>
		<div class="col-sm-8">

			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<td><h3><strong><?= $membre->get_pseudo(); ?></strong></h3></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Prénom</td>
							<td><?= $membre->get_prenom(); ?></td>
						</tr>
						<tr>
							<td>Nom</td>
							<td><?= $membre->get_nom(); ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?= $membre->get_email(); ?></td>
						</tr>
						<tr>
							<td>Date de naissance</td>
							<td><?= $membre->get_date_birth_format(); ?></td>
						</tr>
						<tr>
							<td>Membre depuis le</td>
							<td><?= $membre->get_date_create_format(); ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<a href="?module=membres&page=modification" class="btn btn-primary">Mettre à jour</a>

		</div>
	</div>
</section>