<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : navigation du panneau de contrôle des commentaires
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> affiche le menu de navigation du contrôle des commentaires
 */
//------------------------------------------------------------
// HTML
?>
	<div class="btn-group btn-group-justified" role="group">
		<a href="?module=commentaires&page=dossier&dossier=signalement" type="button" class="btn btn-<?= ($nbReportedCom > 0) ? 'danger' : 'default'; ?>" aria-label="signalements"><i class="fa fa-bullhorn" aria-hidden="true"></i> Voir tous les signalements (<?= $nbReportedCom; ?>)</a>
		<a href="?module=commentaires&page=dossier&dossier=approuve" type="button" class="btn btn-<?= ($nbWaitingCom > 0) ? 'warning' : 'default'; ?>" aria-label="approbations"><i class="fa fa-gavel" aria-hidden="true"></i> Voir toutes les demandes en attente (<?= $nbWaitingCom; ?>)</a>
	</div>