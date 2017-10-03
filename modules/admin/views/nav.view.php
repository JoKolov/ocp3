<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Admin
 * FILE/ROLE : Nav
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> Navigation du panneau de contrôle administrateur
 */

//------------------------------------------------------------
// HTML
?>
  <!-- NAVIGATION -->
  <div class="container-fluid">

    <div class="row">
      <ul class="nav nav-pills nav-justified">

        <li role="presentation" class="<?= $adminNavActive['controlPanel']; ?>">
          <a href="?module=admin&page=controlpanel"><i class="fa fa-bar-chart" aria-hidden="true"></i> Tableau de bord</a>
        </li>

        <li role="presentation" class="<?= $adminNavActive['billets']; ?>">
          <a href="?module=billets&page=admin"><i class="fa fa-book" aria-hidden="true"></i> Billets</a>
        </li>

        <li role="presentation" class="<?= $adminNavActive['commentaires']; ?>">
          <a href="?module=commentaires&page=admin"><i class="fa fa-comments" aria-hidden="true"></i> Commentaires</a>
        </li>
        
        <!--
        <li role="presentation" class="<?= $adminNavActive['membres']; ?>">
          <a href="?module=membres&page=admin"><i class="fa fa-users" aria-hidden="true"></i> Membres</a>
        </li>
        -->

      </ul>
    </div>

  </div>