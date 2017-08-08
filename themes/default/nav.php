<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * THEME : Default
 * FILE/ROLE : Nav
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> Navigation/Menu HTML
 */

//------------------------------------------------------------
// préparation de la class active en fonction de la page
$active['compte'] = '';
$active['home'] = '';
$active['deconnexion'] = '';
$active['connexion'] = '';

if(isset($_GET['page']))
{
	$active[$_GET['page']] = 'class="active"';
}
else
{
	$active['home'] = 'class="active"';
}


//------------------------------------------------------------
// HTML
?>
  <!-- NAVIGATION -->
  <div class="container">
    <nav class="row">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </nav>
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="menu-nav">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Accueil</a></li>
            <li><a href="#">Chapitres</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </div>


  <!-- CONTENU DE LA PAGE -->
  <div id="page-content" class="container">
  	<div class="row content-background">