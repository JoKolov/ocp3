<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue d'un billet
 *
 * File Last Update : 2017 08 31
 *
 * File Description :
 * -> affiche un billet
 */

//------------------------------------------------------------
// Protocoles de sécurités
user_connected_only();
admin_only();


//------------------------------------------------------------
// Génération des valeurs à afficher

//-----
// CODE A DEPLACER
$var = array(
	'titre'		=> '',
	'contenu'	=> '',
	'auteur_id'	=> '',
	'date_publie'	=> '',
	'date_modif'	=> '');
if (isset($_GET['id']) AND $_GET['id'] > 0)
{
	$billetMgr = new BilletMgr;
	$id = $_GET['id'];
	$id = (int) $id;
	$billet = $billetMgr->select($id);
	foreach ($var as $key => $value)
	{
		$method = 'get_' . $key;
		if (method_exists($billet, $method))
		{
			$var[$key] = $billet->$method();
		}
	}
}
else
{
	header('Location: ' . APP['url-website'] . '?page=error404'); die;
}

//-----



//------------------------------------------------------------
// HTML
?>


<section>

	<h3><?= $var['titre']; ?></h3>

	<h6 class="text-right">Publié le <?= $var['date_publie']; ?>, par <?= $var['auteur_id']; ?></h6>

	<div class="panel panel-default">
		<div class="panel-body"><?= $var['contenu']; ?></div>
	</div>



</section>