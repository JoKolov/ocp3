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

	<h3><?= $billet->get_titre(); ?></h3>

	<h6 class="text-right">Publié le <?= $billet->get_date_modif(); ?>, par <?= $auteur->get_pseudo(); ?></h6>

	<div class="panel panel-default">
		<div class="panel-body"><?= $billet->get_contenu(); ?></div>
	</div>



</section>